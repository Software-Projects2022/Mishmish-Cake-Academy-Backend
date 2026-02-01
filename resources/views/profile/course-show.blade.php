@extends('layouts.app')
@section('content')

<div class="container profile-top_detels">
    <div class="course-wrapper">
        <!-- Header Section -->
        <div class="course-header">
            <div class="profile-top">
                <div class="avatar-wrapper">
                    <div class="avatar">م</div>
                </div>
                <div class="profile-details">
                    <h1>
                        {{ $course->title }}
                        <span class="active-badge">
                            <i class="fas fa-check"></i> نشط
                        </span>
                    </h1>
                </div>
            </div>

            <div class="info-grid">
                <div class="info-card">
                    <i class="fas fa-calendar-alt"></i>
                    @php
                        \Carbon\Carbon::setLocale('ar');
                    @endphp
                    <span>انضم في {{ $booking->created_at->isoFormat('D MMMM YYYY') }}</span>
                </div>
                <div class="info-card">
                    <i class="fas fa-check-circle"></i>
                    <span>مفعّل ونشط</span>
                </div>
            </div>
        </div>

        <!-- Content Section -->
        <div class="content-section">
            <div class="section-header">
                <h2>{{ $course->title }}</h2>
            </div>

            <div class="course-description">
                <p>{!! $course->description !!}</p>
            </div>

            <div class="lessons-container">
                @foreach ($course->lessons as $lesson)
                    <div class="lesson-block">
                        <h3 class="lesson-title">{{ $lesson->title }}</h3>

                        <div class="chapters-grid">
                            @foreach ($lesson->chapters as $chapter)
                                <div class="chapter-card">
                                    <div class="chapter-header">
                                        <div class="chapter-title">
                                            <div class="play-icon">
                                                <i class="fas fa-play"></i>
                                            </div>
                                            {{ $chapter->title }}
                                        </div>
                                        <div class="chapter-duration">
                                            <i class="fas fa-clock"></i>
                                            {{ $chapter->duration }}
                                        </div>
                                    </div>

                                    <div class="video-wrapper">
                                        <video src="{{$chapter->video_url}}" controls></video>
                                    </div>

                                    <div class="chapter-description">
                                        {!! $chapter->description !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
