<?php

return [
    'signed_url_expiry_minutes' => (int) env('VIDEO_SIGNED_URL_EXPIRY', 30),

    // Segments inherit the playlist's expiry at fetch time, so this must comfortably
    // exceed the longest video length plus pauses, otherwise playback breaks mid-video.
    'segment_signed_url_expiry_minutes' => (int) env('VIDEO_SEGMENT_URL_EXPIRY', 360),

    'ffmpeg_path' => env('FFMPEG_PATH', 'ffmpeg'),
    'hls_segment_duration' => (int) env('VIDEO_HLS_SEGMENT_DURATION', 10),
];
