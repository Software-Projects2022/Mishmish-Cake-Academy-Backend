<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Services\GcsUploadService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class VideoController extends Controller
{
    protected GcsUploadService $gcsService;

    public function __construct(GcsUploadService $gcsService)
    {
        $this->gcsService = $gcsService;
    }

    /**
     * Get a signed URL for direct upload to GCS.
     */
    public function getSignedUploadUrl(Request $request): JsonResponse
    {
        // Return JSON even on validation error
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'file_name' => 'required|string',
            'mime_type' => 'required|string|starts_with:video/',
            'file_size' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        try {
            // Create a pending video record
            $video = Video::create([
                'name' => pathinfo($request->file_name, PATHINFO_FILENAME),
                'original_name' => $request->file_name,
                'path' => '', // Will be updated after upload
                'url' => '', // Will be updated after upload
                'size' => $request->file_size,
                'mime_type' => $request->mime_type,
                'status' => 'pending',
            ]);

            // Generate signed URL
            $uploadData = $this->gcsService->generateSignedUploadUrl(
                $request->file_name,
                $request->mime_type
            );

            // Update video with path and URL
            $video->update([
                'path' => $uploadData['path'],
                'url' => $uploadData['public_url'],
                'status' => 'uploading',
            ]);

            return response()->json([
                'success' => true,
                'video_id' => $video->id,
                'signed_url' => $uploadData['signed_url'],
                'public_url' => $uploadData['public_url'],
                'expires_in' => $uploadData['expires_in'],
            ]);
        } catch (\Exception $e) {
            Log::error('GCS Upload Error: ' . $e->getMessage());
            
            // Return JSON error instead of HTML page
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في السيرفر: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Confirm upload completion.
     */
    public function confirmUpload(Request $request): JsonResponse
    {
        try {
            $video = Video::findOrFail($request->video_id);

            // Verify file exists in GCS
            if (!$this->gcsService->fileExists($video->path)) {
                $video->update(['status' => 'failed']);
                return response()->json([
                    'success' => false,
                    'message' => 'الملف غير موجود في التخزين',
                ], 404);
            }

            $video->update([
                'status' => 'completed',
                'duration' => $request->duration,
            ]);

            return response()->json([
                'success' => true,
                'video' => $video,
            ]);
        } catch (\Exception $e) {
            Log::error('GCS Confirm Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'فشل تأكيد الرفع: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Cancel/delete a pending upload.
     */
    public function cancelUpload(Request $request): JsonResponse
    {
        try {
            $video = Video::findOrFail($request->video_id);

            // Delete from GCS if exists
            if ($video->path) {
                $this->gcsService->deleteFile($video->path);
            }

            $video->delete();

            return response()->json([
                'success' => true,
                'message' => 'Upload cancelled',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel upload: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get all completed videos (for selection in Filament).
     */
    public function index(): JsonResponse
    {
        $videos = Video::where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'videos' => $videos,
        ]);
    }

    /**
     * Delete a video.
     */
    public function destroy(Video $video): JsonResponse
    {
        try {
            // Delete from GCS
            if ($video->path) {
                $this->gcsService->deleteFile($video->path);
            }

            $video->delete();

            return response()->json([
                'success' => true,
                'message' => 'Video deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete video: ' . $e->getMessage(),
            ], 500);
        }
    }
}
