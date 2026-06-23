<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Services\GcsUploadService;
use App\Services\VideoAccessService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;

class VideoStreamController extends Controller
{
    public function __construct(
        protected GcsUploadService $gcsService,
        protected VideoAccessService $accessService
    ) {
    }

    public function playbackInfo(Chapter $chapter): JsonResponse
    {
        $client = auth()->guard('client')->user();

        if (!$this->accessService->canClientWatchChapter($client, $chapter)) {
            return response()->json(['success' => false, 'message' => 'غير مصرح لك بمشاهدة هذا الفيديو'], 403);
        }

        $chapter->loadMissing('video');

        if (!$chapter->video) {
            return response()->json(['success' => false, 'message' => 'لا يوجد فيديو لهذه المحاضرة'], 404);
        }

        $video = $chapter->video;

        if ($video->hls_status === 'ready' && $video->hls_path) {
            return response()->json([
                'success' => true,
                'type' => 'hls',
                'src' => route('chapter.video.playlist', $chapter),
                'watermark' => $this->accessService->watermarkLabel($client),
                'processing' => false,
            ]);
        }

        if (!$video->path || !$this->gcsService->fileExists($video->path)) {
            return response()->json(['success' => false, 'message' => 'الفيديو غير متاح حالياً'], 404);
        }

        return response()->json([
            'success' => true,
            'type' => 'mp4',
            'src' => $this->gcsService->generateSignedReadUrl($video->path),
            'watermark' => $this->accessService->watermarkLabel($client),
            'processing' => in_array($video->hls_status, ['pending', 'processing'], true),
        ]);
    }

    public function streamMp4(Chapter $chapter)
    {
        $client = auth()->guard('client')->user();

        if (!$this->accessService->canClientWatchChapter($client, $chapter)) {
            abort(403, 'غير مصرح لك بمشاهدة هذا الفيديو');
        }

        $chapter->loadMissing('video');

        if (!$chapter->video?->path || !$this->gcsService->fileExists($chapter->video->path)) {
            abort(404, 'الفيديو غير متاح');
        }

        return redirect()->away(
            $this->gcsService->generateSignedReadUrl($chapter->video->path)
        );
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

        $playlist = $this->gcsService->getObjectContents($video->hls_path);
        $hlsDir = dirname($video->hls_path);
        $keyUrl = route('chapter.video.key', $chapter);
        $segmentExpiry = config('video.segment_signed_url_expiry_minutes', 360);
        $lines = preg_split('/\r\n|\r|\n/', $playlist) ?: [];
        $rewritten = [];

        foreach ($lines as $line) {
            $trimmed = trim($line);

            if ($trimmed === '') {
                $rewritten[] = $line;
                continue;
            }

            if (str_starts_with($trimmed, '#EXT-X-KEY:')) {
                $rewritten[] = preg_replace(
                    '/URI="[^"]*"/',
                    'URI="' . $keyUrl . '"',
                    $trimmed
                );
                continue;
            }

            if (!str_starts_with($trimmed, '#') && str_ends_with($trimmed, '.ts')) {
                // Use basename so this works whether ffmpeg wrote relative or absolute segment paths.
                $segmentPath = $hlsDir . '/' . basename($trimmed);
                $rewritten[] = $this->gcsService->generateSignedReadUrl($segmentPath, $segmentExpiry);
                continue;
            }

            $rewritten[] = $line;
        }

        return response(implode(PHP_EOL, $rewritten), 200, [
            'Content-Type' => 'application/vnd.apple.mpegurl',
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
        ]);
    }

    public function decryptionKey(Chapter $chapter): Response
    {
        $client = auth()->guard('client')->user();

        if (!$this->accessService->canClientWatchChapter($client, $chapter)) {
            abort(403, 'غير مصرح لك بمشاهدة هذا الفيديو');
        }

        $chapter->loadMissing('video');
        $video = $chapter->video;

        if (!$video || !$video->encryption_key) {
            abort(404, 'مفتاح التشفير غير متاح');
        }

        $key = base64_decode(Crypt::decryptString($video->encryption_key), true);

        if ($key === false || strlen($key) !== 16) {
            abort(500, 'مفتاح التشفير غير صالح');
        }

        return response($key, 200, [
            'Content-Type' => 'application/octet-stream',
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
        ]);
    }
}
