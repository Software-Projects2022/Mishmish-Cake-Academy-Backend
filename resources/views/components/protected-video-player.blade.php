@props(['chapter'])

@php
    $hasProtectedVideo = (bool) $chapter->video;
@endphp

@if($hasProtectedVideo)
    <div
        class="protected-video-player"
        data-chapter-id="{{ $chapter->id }}"
        data-playback-url="{{ route('chapter.video.playback', $chapter) }}"
    >
        <div class="protected-video-player__container">
            <video
                class="protected-video-player__video"
                controls
                controlsList="nodownload noplaybackrate"
                disablePictureInPicture
                playsinline
                preload="metadata"
            ></video>
            <div class="protected-video-player__watermark" aria-hidden="true"></div>
        </div>
        <div class="protected-video-player__status protected-video-player__status--loading">
            جاري تحميل الفيديو...
        </div>
    </div>
@elseif($chapter->video_url)
    <div class="protected-video-player">
        <div class="protected-video-player__container">
            <video
                class="protected-video-player__video"
                src="{{ $chapter->video_url }}"
                controls
                controlsList="nodownload noplaybackrate"
                disablePictureInPicture
                playsinline
            ></video>
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
        <script src="{{ asset('assets/js/protected-video.js') }}"></script>
    @endpush
@endonce
