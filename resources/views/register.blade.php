@extends('layouts.app')

@section('content')

    <div class="container_main_login">
        <div class="auth-card">
            <div class="auth-header">
                <i class="fas fa-user-plus"></i>
                <h1>إنشاء حساب جديد</h1>
                <p>قم بالتسجيل للوصول إلى جميع الدورات والخدمات</p>
            </div>

            <form id="registrationForm">
                <div class="form-row">
                    <div class="form-group">
                        <label>الاسم الأول</label>
                        <div class="input-wrapper">
                            <input type="text" class="form-control" placeholder="أدخل اسمك الأول" required>
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>الاسم الأخير</label>
                        <div class="input-wrapper">
                            <input type="text" class="form-control" placeholder="أدخل اسمك الأخير" required>
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>البريد الإلكتروني</label>
                    <div class="input-wrapper">
                        <input type="email" class="form-control" placeholder="example@email.com" required>
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>رقم الهاتف</label>
                    <div class="input-wrapper">
                        <input type="tel" class="form-control" placeholder="+20 123 456 7890" required>
                        <i class="fas fa-phone"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>كلمة المرور</label>
                    <div class="input-wrapper">
                        <input type="password" class="form-control" placeholder="أدخل كلمة المرور" required>
                        <i class="fas fa-lock"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label>تأكيد كلمة المرور</label>
                    <div class="input-wrapper">
                        <input type="password" class="form-control" placeholder="أعد إدخال كلمة المرور" required>
                        <i class="fas fa-lock"></i>
                    </div>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="terms" required>
                    <label for="terms">
                        أوافق على <a href="#">الشروط والأحكام</a> و <a href="#">سياسة الخصوصية</a>
                    </label>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-user-check"></i> إنشاء حساب
                </button>
            </form>


            <div class="auth-footer">
                لديك حساب بالفعل؟ <a href="{{ route('login') }}">تسجيل الدخول</a>
            </div>
        </div>
    </div>

@endsection
