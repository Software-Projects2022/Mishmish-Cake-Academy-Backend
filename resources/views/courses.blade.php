@extends('layouts.app')
@section('content')



    <main>
        <section class="hero_courses">
            <div class="container">
                <div class="hero">
                    <h2>استكشف دوراتنا</h2>
                    <p>مجموعة متنوعة من الدورات المصممة لتعليمك فن خبز الكيك وتزيينه باحترافية.</p>
                </div>

                <div class="filter-section">

                    <a href="#all" class="filter-btn active">جميع الدورات</a>
                    @forelse ($course_categories as $course_category)
                    <a href="#{{ $course_category->id }}" class="filter-btn">{{ $course_category->title }}</a>
                    @empty
                    @endforelse
                </div>

                <div class="courses-grid">


                    @forelse ($courses as $course)


                    <div class="course-card" data-level="{{ $course->course_category_id ??'' }}">
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
                                <span class="course-duration"><i class="fa-regular fa-clock"></i> {{ $course->lessons->sum('total_duration') }} ساعة</span>
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

    </main>

@endsection
