@extends('layouts.app')

@section('content')
<main>
    <section class="banner-slider">
        @forelse ($sliders as $slider)
            <div class="slide">
                <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}">

                <div class="slide-content">
                    <h2>{{ $slider->title }}</h2>
                    <p>{{ $slider->subtitle }}</p>
                    <a href="{{ $slider->button_url }}" class="hero-btn">اقرأ المزيد</a>
                </div>
            </div>
        @empty

        @endforelse

    </section>


    @forelse ($pages_top as $page)

    @if ($loop->iteration % 2 == 0)
    <section class="container">
        <div class="gird_about_main_home">
            <div class="image-section">
                <div class="image-wrapper">
                    <img src="{{ asset('storage/' . $page->image) }}"
                        alt="{{ $page->title }}" class="cake-image">
                </div>
            </div>

            <div class="content">
                <h2>{{ $page->title }}</h2>

                <div class="text-content">
                    <p>{{ $page->short_description }}</p>
                </div>

                <a href="" class="read-more-btn">اقرأ المزيد</a>
            </div>

        </div>
    </section>
    @else
    <section class="container">
        <div class="gird_about_main_home">
            <div class="content">
                <h2>{{ $page->title }}</h2>

                <div class="text-content">
                    <p>{{ $page->short_description }}</p>
                </div>

                <a href="" class="read-more-btn">اقرأ المزيد</a>
            </div>

            <div class="image-section">
                <div class="image-wrapper">
                    <img src="{{ asset('storage/' . $page->image) }}"
                        alt="{{ $page->title }}" class="cake-image">
                </div>
            </div>
        </div>
    </section>

    @endif
    @empty

    @endforelse





    <div class="container">

        <div class="header_servis_home">
            <h2>استكشف دوراتنا</h2>
        </div>


        <div class="courses-grid">

            @forelse ($courses as $course)
            <div class="course-card" data-level="{{ $course->courseCategory->title??'' }}">
                <div class="course-image">
                    <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}">
                </div>
                <div class="course-content">
                    <span class="course-level level-beginner">{{ $course->courseCategory->title??'' }}</span>
                    <h3 class="course-title">{{ $course->title }}</h3>
                    <p class="course-description">
                        {{ $course->short_description }}
                    </p>
                    <div class="course-info">
                        <span class="course-duration">
                            <i class="fa-regular fa-clock"></i>

                             {{ $course->lessons->sum('total_duration') }}
                             ساعة</span>
                        <span class="course-price">{{ $course->price }} جنيه</span>
                    </div>
                    <a href="{{ route('course.details', $course->id) }}" class="enroll-btn">سجّل الآن</a>
                </div>
            </div>

            @empty

            @endforelse


        </div>
    </div>
    </section>


    @forelse ($pages_bottom as $page)
    @if ($loop->iteration % 2 != 0)
    <section class="container">
        <div class="gird_about_main_home">
            <div class="image-section">
                <div class="image-wrapper">
                    <img src="{{ asset('storage/' . $page->image) }}"
                        alt="{{ $page->title }}" class="cake-image">
                </div>
            </div>

            <div class="content">
                <h2>{{ $page->title }}</h2>

                <div class="text-content">
                    <p>{{ $page->short_description }}</p>
                </div>

                <a href="" class="read-more-btn">اقرأ المزيد</a>
            </div>

        </div>
    </section>
    @else
    <section class="container">
        <div class="gird_about_main_home">
            <div class="content">
                <h2>{{ $page->title }}</h2>

                <div class="text-content">
                    <p>{{ $page->short_description }}</p>
                </div>

                <a href="" class="read-more-btn">اقرأ المزيد</a>
            </div>

            <div class="image-section">
                <div class="image-wrapper">
                    <img src="{{ asset('storage/' . $page->image) }}"
                        alt="{{ $page->title }}" class="cake-image">
                </div>
            </div>
        </div>
    </section>
    @endif
    @empty
    @endforelse






    <section class="recent_designs">
        <div class="container">
            <h2>أحدث التصميمات</h2>
            <div class="grid_img">


                @forelse ($designs as $design)
                <div class="col_recent_designs">
                    <img src="{{ asset('storage/' . $design->image) }}" alt="{{ $design->title??'' }}">
                    <h3>{{ $design->title }}</h3>
                </div>
                @empty
                @endforelse
            </div>
            <a href="#" class="read-more-btn">اقرأ المزيد</a>
        </div>
    </section>

</main>


@endsection
