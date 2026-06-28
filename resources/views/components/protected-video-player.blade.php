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
                controls
                controlsList="nodownload noplaybackrate"
                disablePictureInPicture
                playsinline
                preload="none"
            ></video>
            <div class="protected-video-player__watermark" aria-hidden="true"></div>
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
        <link rel="stylesheet" href="{{ asset('assets/css/protected-video.css') }}">
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/hls.js@1.5.17/dist/hls.min.js"></script>
        <script src="{{ asset('assets/js/protected-video.js') }}?v=5"></script>
    @endpush
@endonce
