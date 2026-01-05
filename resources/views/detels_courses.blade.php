@extends('layouts.app')
@section('content')
    <main>
        <!-- Header -->
        <div class="gradient-bg">
            <div class="container">
                <div>
                    <span class="badge">
                        <i class="fas fa-graduation-cap"></i> أفضل دورة مبيعاً
                    </span>
                    <h1>{{ $course->title }}</h1>
                    <p class="subtitle">{{ $course->short_description }}</p>
                    <div class="stats">
                        <div class="stat-item">
                            <i class="fas fa-star" style="color: #fbbf24;"></i>
                            <span style="font-weight: bold;">4.9/5</span>
                            <span style="opacity: 0.8;">(2450 مراجعة)</span>
                        </div>
                        <div class="stat-item">
                            <i class="fas fa-users"></i>
                            <span style="font-weight: bold;">15,789 طالب</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                <div class="container main-content_main">
            <div class="grid">
                <!-- Main Content -->
                <div>
                    <!-- Video Section -->
                    <div class="card">
                        <h2>
                            <i class="fas fa-video"></i> فيديو مقدمة الدورة
                        </h2>
                        <div class="video-container">
                            <video src="{{ asset('storage/' . $course->video) }}" controls></video>
                        </div>
                    </div>

                    <!-- Course Description -->
                    <div class="card">
                        <h2>
                            <i class="fas fa-file-alt"></i> عن الدورة
                        </h2>
                        <p class="description">
                             {!! $course->description !!}
                        </p>

                        <div class="features-grid">
                            <div class="feature-item">
                                <i class="fas fa-check-circle" style="color: #10b981;"></i>
                                <div>
                                    <h4>تطبيق عملي</h4>
                                    <p>{{ $course->lessons->count() }} درس</p>
                                </div>
                            </div>

                            <div class="feature-item">
                                <i class="fas fa-certificate" style="color: #3b82f6;"></i>
                                <div>
                                    <h4>شهادة معتمدة</h4>
                                    <p>تحصل على شهادة إتمام الدورة</p>
                                </div>
                            </div>

                            <div class="feature-item">
                                <i class="fas fa-comments" style="color: #7c3aed;"></i>
                                <div>
                                    <h4>دعم مستمر</h4>
                                    <p>تواصل مباشر مع المدرب والطلاب</p>
                                </div>
                            </div>

                            <div class="feature-item">
                                <i class="fas fa-infinity" style="color: #ec4899;"></i>
                                <div>
                                    <h4>وصول مدى الحياة</h4>
                                    <p>شاهدي المحتوى بأي وقت</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Course Content -->
                    <div class="card">
                        <h2>
                            <i class="fas fa-book"></i> محتوى الدورة
                        </h2>

                        <div>
                            @forelse ($course->lessons as $lesson)
                            <details @if ($loop->iteration == 1) open @endif>
                                <summary style="color:{{ $lesson->color }};">
                                    <i class="fas fa-layer-group"></i> {{ $lesson->title }} ({{ $lesson->chapters->count() }} دروس)
                                </summary>
                                <ul>
                                    @forelse ($lesson->chapters as $chapter)
                                    <li><i class="fas fa-check"></i> {{ $chapter->title }}</li>
                                    @empty
                                    <li>لا يوجد محتوى للدورة</li>
                                    @endforelse
                                </ul>
                            </details>
                            @empty
                            <p>لا يوجد محتوى للدورة</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Instructor -->
                    <div class="card">
                        <h2>
                            <i class="fas fa-user-tie"></i> المدربة
                        </h2>

                        <div class="instructor-card">
                            <div class="instructor-avatar">
                                {{-- <i class="fas fa-user-chef"></i> --}}
                                <img style="width: 100px; height: 100px; border-radius: 50%;" src="{{ asset('storage/' . $course->instructor->image) }}" alt="{{ $course->instructor->name }}">
                            </div>

                            <div class="instructor-info">
                                <h3>{{ $course->instructor->name }}</h3>
                                <p class="instructor-title">
                                    <i class="fas fa-utensils"></i>{{ $course->instructor->title }}
                                </p>

                                <p class="instructor-bio">
                                    {{ $course->instructor->description }}
                                </p>

                                <div class="instructor-stats">
                                    {{-- <div>
                                        <i class="fas fa-star"></i>
                                        <span style="font-weight: bold;">4.9</span>
                                        <span style="color: #6b7280;">تقييم المدربة</span>
                                    </div>
 --}}
                                    <div>
                                        <i class="fas fa-graduation-cap"></i>
                                        <span style="font-weight: bold;">{{ $course->instructor->courses->count() }}</span>
                                        <span style="color: #6b7280;">دورة</span>
                                    </div>

                                    {{-- <div>
                                        <i class="fas fa-users"></i>
                                        <span style="font-weight: bold;">25,000+</span>
                                        <span style="color: #6b7280;">طالب</span>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Price Card -->
                    <div class="price-card">
                        <div class="price-header">
                            <div class="original-price">السعر الأصلي</div>
                            <div class="old-price">{{ $course->price }} جنيه</div>
                            <div class="current-price">{{ $course->price_after_discount }} جنيه</div>
                            {{-- <div class="discount-badge">
                                <i class="fas fa-tag"></i> <span>خصم 50%</span> - سارع قبل انتهاء العرض!
                            </div> --}}
                        </div>

                        <div class="price-body">

                            @guest('client')
                                <button onclick="window.location.href='{{ route('login') }}'" class="btn btn-primary">
                                    <i class="fas fa-rocket"></i> تسجيل الآن
                                </button>
                            @endguest

                            @auth('client')
                                @if (auth()->guard('client')->user()->bookings()->where('course_id', $course->id)->exists())
                                <button onclick="window.location.href='{{ route('dashboard') }}'" class="btn btn-primary">
                                    <i class="fas fa-check-circle"></i> تم تسجيل الدورة بنجاح
                                </button>
                                @else
                                <form action="{{ route('course.book', $course->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-rocket"></i> تسجيل الآن
                                    </button>
                                </form>
                                @endif
                            @endauth
                            {{-- <button class="btn btn-secondary">
                                <i class="fas fa-shopping-cart"></i> إضافة إلى السلة
                            </button>
 --}}
                            <div class="guarantee">
                                <i class="fas fa-shield-alt"></i> ضمان استرجاع المال لمدة 30 يوم
                            </div>
                        </div>
                    </div>

                    <!-- Course Info -->
                    <div class="info-card">
                        <h3>
                            <i class="fas fa-info-circle" style="color:var(--main-color);"></i>
                            معلومات الدورة
                        </h3>

                        <div class="info-list">
                            <p><i class="fas fa-play"></i> مدة الدورة:{{ $course->lessons->sum('total_duration') }}
                                ساعة</p>
                            <p><i class="fas fa-video"></i> {{ $course->lessons->count('total_chapters') }} درس فيديو</p>
                            <p><i class="fas fa-infinity"></i> وصول مدى الحياة</p>
                            <p><i class="fas fa-certificate"></i> شهادة معتمدة</p>
                            <p><i class="fas fa-mobile"></i> تعمل على جميع الأجهزة</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'تم بنجاح',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        });
    </script>
    @endif
    @endsection
