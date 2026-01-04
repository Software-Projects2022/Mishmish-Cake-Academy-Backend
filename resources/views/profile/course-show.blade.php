@extends('layouts.app')
@section('content')
<div class="container">
    <div class="container_profil">
        <div class="header">
            <div class="profile-section">
                <div class="avatar">م</div>
                <div class="profile-info">
                    <h1>
                        {{ $course->title }}
                        <span class="active-badge">نشط</span>
                    </h1>
                </div>
            </div>

            <div class="info-row">
                <div class="info-item">
                    <i class="fas fa-calendar-alt"></i>
                    @php
                        \Carbon\Carbon::setLocale('ar');
                    @endphp

                    انضم في {{ $booking->created_at->isoFormat('D MMMM YYYY') }}

                </div>
                <div class="info-item">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>

        <div class="programs-section">
            <h2 class="section-title">{{ $course->title }}</h2>
            <div class="course-info">
                <p>{!! $course->description !!}</p>
            </div>

            <div class="course-video">

                @foreach ($course->lessons as $lesson)

                <h3>{{ $lesson->title }}</h3>
                    @foreach ($lesson->chapters as $chapter)
                        <div class="chapter-item">
                            <h4>{{ $chapter->title }}</h4>
                            <video src="{{ asset('storage/' . $chapter->video_url) }}" controls></video>

                            <div class="chapter-duration">
                                <i class="fas fa-clock"></i>
                                {{ $chapter->duration }}
                            </div>
                            <div class="chapter-icon">
                                <i class="fas fa-play"></i>
                                <p>{!! $chapter->description !!}</p>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>

    </div>

</div>
@endsection
