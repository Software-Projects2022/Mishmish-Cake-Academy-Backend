<header class="header_main_nav">
    <!-- Overlay for mobile menu -->
    <div class="overlay" id="overlay" onclick="toggleMenu()"></div>

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="top-bar-content">
                <div class="contact-info">
                    <a href="tel:{{ $contact->phone ?? '' }}">
                        <i class="fas fa-phone"></i>
                        <span>{{ $contact->phone ?? '' }}</span>
                    </a>
                    <a href="mailto:{{ $contact->email ?? '' }}">
                        <i class="fas fa-envelope"></i>
                        <span>{{ $contact->email ?? '' }}</span>
                    </a>
                    <div class="social-links">
                        @if($contact)
                            <a href="{{ $contact->facebook }}" title="فيسبوك" target="_blank" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="{{ $contact->instagram }}" title="انستجرام" target="_blank" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="{{ $contact->pinterest }}" title="بنترست" target="_blank" aria-label="Pinterest">
                                <i class="fab fa-pinterest-p"></i>
                            </a>
                            <a href="{{ $contact->vimeo }}" title="فيميو" target="_blank" aria-label="Vimeo">
                                <i class="fab fa-vimeo-v"></i>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="account-cart">
                    @auth('client')
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-user"></i>
                        <span>حسابي</span>
                    </a>

                            <form action="{{ route('client.logout') }}" method="POST">
                        @csrf
                        <a o onclick="event.preventDefault(); this.closest('form').submit();" class="btn-logout">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>تسجيل الخروج</span>
                        </a>
                    </form>

                    @endauth
                    @guest('client')
                    <a href="{{ route('login') }}">
                        <i class="fas fa-user"></i>
                        <span>تسجيل الدخول</span>
                    </a>
                    @endguest
                </div>


            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="main-header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('assets/img/logo.png') }}" alt="شعار الموقع">
                    </a>
                </div>


                <nav id="mainNav">
                    <ul>
                        <li><a href="{{ route('home') }}" class="active">الرئيسية</a></li>
                        <li><a href="{{ route('courses') }}">الدورات</a></li>
                        <li><a href="{{ route('about-us') }}">من نحن</a></li>
                        <li><a href="#">ورش العمل</a></li>
                        <li><a href="#">تواصل معنا</a></li>
                    </ul>
                </nav>

                <button class="mobile-menu-btn_tow" aria-label="تغيير اللغة">
                    <i class="fas fa-globe"></i> EN
                </button>



                <button class="mobile-menu-btn" onclick="toggleMenu()" aria-label="القائمة">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>

</header>
