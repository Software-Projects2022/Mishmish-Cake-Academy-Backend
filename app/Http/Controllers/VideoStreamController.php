<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Services\GcsUploadService;
use App\Services\HlsPlaylistService;
use App\Services\VideoAccessService;
use App\Services\VideoPlaybackTokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;

class VideoStreamController extends Controller
{
    public function __construct(
        protected GcsUploadService $gcsService,
        protected VideoAccessService $accessService,
        protected HlsPlaylistService $playlistService,
        protected VideoPlaybackTokenService $tokenService
    ) {
    }

    public function playbackInfo(Chapter $chapter): JsonResponse
    {
        $client = auth()->guard('client')->user();

        if (!$this->accessService->canClientWatchChapter($client, $chapter)) {
            return response()->json(['success' => false, 'message' => 'غير مصرح لك بمشاهدة هذا الفيديو'], 403);
        }

        $watermark = $this->accessService->watermarkLabel($client);
        $chapter->loadMissing('video');

        if ($chapter->video) {
            return $this->playbackForVideoLibrary($chapter, $watermark);
        }

        return $this->playbackForLegacyChapter($chapter, $watermark);
    }

    public function playlist(Chapter $chapter): Response
    {
        $client = auth()->guard('client')->user();

        if (!$this->accessService->canClientWatchChapter($client, $chapter)) {
            abort(403, 'غير مصرح لك بمشاهدة هذا الفيديو');
        }

        $chapter->loadMissing('video');
        $video = $chapter->video;

        if (!$video || $video->hls_status !== 'ready' || !$video->hls_path) {
            abort(404, 'قائمة التشغيل غير متاحة');
        }

        $token = $this->tokenService->generate($client->id, $video->id);
        $keyUrl = $this->tokenService->appendToUrl(
            route('chapter.video.key', $chapter),
            $token
        );

        $body = $this->playlistService->injectKeyUri(
            $this->playlistService->getSignedPlaylistBody($video),
            $keyUrl
        );

        return response($body, 200, [
            'Content-Type' => 'application/vnd.apple.mpegurl',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, private',
            'Pragma' => 'no-cache',
        ]);
    }

    public function decryptionKey(Request $request, Chapter $chapter): Response
    {
        $client = auth()->guard('client')->user();

        if (!$this->accessService->canClientWatchChapter($client, $chapter)) {
            $this->tokenService->logKeyAccess('key_denied', $client?->id ?? 0, 0, $chapter->id, 'access_denied');
            abort(403, 'غير مصرح لك بمشاهدة هذا الفيديو');
        }

        $chapter->loadMissing('video');
        $video = $chapter->video;

        if (!$video || !$video->encryption_key) {
            $this->tokenService->logKeyAccess('key_denied', $client->id, $video?->id ?? 0, $chapter->id, 'no_encryption_key');
            abort(404, 'مفتاح التشفير غير متاح');
        }

        if (!$this->tokenService->validate($request->query('token'), $client->id, $video->id)) {
            $this->tokenService->logKeyAccess('key_denied', $client->id, $video->id, $chapter->id, 'invalid_token');
            abort(403, 'جلسة التشغيل غير صالحة أو منتهية');
        }

        $key = base64_decode(Crypt::decryptString($video->encryption_key), true);

        if ($key === false || strlen($key) !== 16) {
            $this->tokenService->logKeyAccess('key_denied', $client->id, $video->id, $chapter->id, 'invalid_stored_key');
            abort(500, 'مفتاح التشفير غير صالح');
        }

        $this->tokenService->logKeyAccess('key_granted', $client->id, $video->id, $chapter->id);

        return response($key, 200, [
            'Content-Type' => 'application/octet-stream',
            'Content-Length' => (string) strlen($key),
            'Cache-Control' => 'no-store, no-cache, must-revalidate, private',
            'Pragma' => 'no-cache',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    protected function playbackForVideoLibrary(Chapter $chapter, string $watermark): JsonResponse
    {
        $video = $chapter->video;

        if ($video->hls_status === 'ready' && $video->hls_path) {
            return response()->json([
                'success' => true,
                'type' => 'hls',
                'src' => route('chapter.video.playlist', $chapter),
                'watermark' => $watermark,
                'processing' => false,
            ]);
        }

        $isProcessing = in_array($video->hls_status, ['pending', 'processing'], true);

        if ($isProcessing || !config('video.allow_mp4_fallback', false)) {
            return response()->json([
                'success' => true,
                'type' => 'processing',
                'src' => null,
                'watermark' => $watermark,
                'processing' => true,
                'message' => $isProcessing
                    ? 'جاري تجهيز نسخة محمية من الفيديو...'
                    : 'الفيديو غير متاح حالياً. يُرجى المحاولة لاحقاً.',
            ]);
        }

        if (!$video->path) {
            return response()->json(['success' => false, 'message' => 'الفيديو غير متاح حالياً'], 404);
        }

        return response()->json([
            'success' => true,
            'type' => 'mp4',
            'src' => $this->gcsService->generateSignedReadUrl($video->path),
            'watermark' => $watermark,
            'processing' => false,
        ]);
    }

    protected function playbackForLegacyChapter(Chapter $chapter, string $watermark): JsonResponse
    {
        $legacyUrl = $chapter->getRawOriginal('video_url');

        if (!$legacyUrl) {
            return response()->json(['success' => false, 'message' => 'لا يوجد فيديو لهذه المحاضرة'], 404);
        }

        $gcsPath = $this->gcsService->pathFromPublicUrl($legacyUrl);

        if ($gcsPath) {
            return response()->json([
                'success' => true,
                'type' => 'mp4',
                'src' => $this->gcsService->generateSignedReadUrl($gcsPath),
                'watermark' => $watermark,
                'processing' => false,
                'legacy' => true,
            ]);
        }

        return response()->json([
            'success' => true,
            'type' => 'mp4',
            'src' => $legacyUrl,
            'watermark' => $watermark,
            'processing' => false,
            'legacy' => true,
        ]);
    }
}
