@extends('layouts.app')

    @section('content')

    <main>
        <div class="container_main_login">
            <div class="auth-card">
                <div class="auth-header">
                    <i class="fas fa-sign-in-alt"></i>
                    <h1>تسجيل الدخول</h1>
                    <p>مرحباً بعودتك! قم بتسجيل الدخول للمتابعة</p>
                </div>

                <form id="loginForm">
                    <div class="form-group">
                        <label>البريد الإلكتروني</label>
                        <div class="input-wrapper">
                            <input type="email" class="form-control" placeholder="example@email.com" required>
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>كلمة المرور</label>
                        <div class="input-wrapper">
                            <input type="password" class="form-control" placeholder="أدخل كلمة المرور" required>
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>

                    <div class="form-options">
                        <div class="remember-me">
                            <input type="checkbox" id="remember">
                            <label for="remember">تذكرني</label>
                        </div>
                        <a href="#" class="forgot-password">نسيت كلمة المرور؟</a>
                    </div>

                    <a href="{{ route('profile') }}" type="submit" class="btn-submit">
                        <i class="fas fa-sign-in-alt"></i> تسجيل الدخول
                    </a>
                </form>
                <div class="auth-footer">
                    ليس لديك حساب؟ <a href="{{ route('register') }}">إنشاء حساب جديد</a>
                </div>
            </div>
        </div>
    </main>
    @endsection


