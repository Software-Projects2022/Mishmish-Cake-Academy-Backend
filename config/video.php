<?php

return [
    'signed_url_expiry_minutes' => (int) env('VIDEO_SIGNED_URL_EXPIRY', 30),
    'ffmpeg_path' => env('FFMPEG_PATH', 'ffmpeg'),
    'hls_segment_duration' => (int) env('VIDEO_HLS_SEGMENT_DURATION', 10),
];
