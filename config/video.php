<?php

return [
    'signed_url_expiry_minutes' => (int) env('VIDEO_SIGNED_URL_EXPIRY', 30),

    // Must exceed longest video length plus pauses; encryption is the primary leak defense.
    'segment_signed_url_expiry_minutes' => (int) env('VIDEO_SEGMENT_URL_EXPIRY', 120),

    // Cache signed segment URLs to avoid repeated RSA signing (must be < segment expiry).
    'playlist_cache_minutes' => (int) env('VIDEO_PLAYLIST_CACHE_MINUTES', 55),

    // Short-lived HMAC token appended to the decryption key URL in the manifest.
    'key_token_ttl_minutes' => (int) env('VIDEO_KEY_TOKEN_TTL', 30),

    // When false, only HLS-ready videos play; others show a processing message.
    'allow_mp4_fallback' => filter_var(
        trim((string) env('VIDEO_ALLOW_MP4_FALLBACK', 'true')),
        FILTER_VALIDATE_BOOLEAN
    ),

    'ffmpeg_path' => env('FFMPEG_PATH', 'ffmpeg'),
    'hls_segment_duration' => (int) env('VIDEO_HLS_SEGMENT_DURATION', 10),

    'burn_watermark' => filter_var(env('VIDEO_BURN_WATERMARK', false), FILTER_VALIDATE_BOOL),
    'watermark_font' => env('VIDEO_WATERMARK_FONT'),
    'hls_burn_brand_watermark' => filter_var(env('VIDEO_HLS_BURN_BRAND', false), FILTER_VALIDATE_BOOL),
    'brand_watermark_text' => env('VIDEO_BRAND_WATERMARK', 'Mishmish Cake Academy'),

    // Comma-separated origins for GCS CORS (defaults to APP_URL).
    'cors_origins' => array_filter(array_map('trim', explode(',', env('VIDEO_CORS_ORIGINS', '')))),
];
