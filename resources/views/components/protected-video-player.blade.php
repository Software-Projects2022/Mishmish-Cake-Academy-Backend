@props(['chapter'])

@php
    $hasVideo = (bool) $chapter->video || $chapter->getRawOriginal('video_url');
    $client = auth()->guard('client')->user();
    $watermark = $client ? app(\App\Services\VideoAccessService::class)->watermarkLabel($client) : '';
@endphp

@if($hasVideo)
    <div
        class="protected-video-player{{ $chapter->video ? '' : ' protected-video-player--legacy' }}"
        data-chapter-id="{{ $chapter->id }}"
        data-playback-url="{{ route('chapter.video.playback', $chapter) }}"
        @if(!$chapter->video && $watermark) data-watermark="{{ $watermark }}" @endif
    >
        <div class="protected-video-player__container">
            <video
                class="protected-video-player__video"
                playsinline
                webkit-playsinline
                disablePictureInPicture
                disableremoteplayback
                preload="none"
            ></video>
            <div class="protected-video-player__watermark" aria-hidden="true"></div>
            <div class="protected-video-player__controls" hidden>
                <button
                    type="button"
                    class="protected-video-player__play-btn"
                    aria-label="تشغيل"
                    title="تشغيل"
                >
                    <span class="protected-video-player__play-icon protected-video-player__play-icon--play" aria-hidden="true">▶</span>
                    <span class="protected-video-player__play-icon protected-video-player__play-icon--pause" aria-hidden="true">❚❚</span>
                </button>
                <input
                    type="range"
                    class="protected-video-player__progress"
                    min="0"
                    max="100"
                    value="0"
                    step="0.1"
                    aria-label="موضع التشغيل"
                >
                <span class="protected-video-player__time" aria-hidden="true">0:00 / 0:00</span>
                <button
                    type="button"
                    class="protected-video-player__fs-btn"
                    aria-label="ملء الشاشة"
                    aria-pressed="false"
                    title="ملء الشاشة"
                >
                    <span class="protected-video-player__fs-icon protected-video-player__fs-icon--enter" aria-hidden="true">⛶</span>
                    <span class="protected-video-player__fs-icon protected-video-player__fs-icon--exit" aria-hidden="true">✕</span>
                </button>
            </div>
        </div>
        <div class="protected-video-player__status protected-video-player__status--loading">
            جاري تحميل الفيديو...
        </div>
    </div>
@else
    <div class="no-video">لا يوجد فيديو</div>
@endif

@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/css/protected-video.css') }}?v=3">
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/hls.js@1.5.17/dist/hls.min.js"></script>
        <script src="{{ asset('assets/js/protected-video.js') }}?v=8"></script>
    @endpush
@endonce
