@extends('layouts.app')

@section('content')

    <div class="container_main_login">
        <div class="auth-card">
            <div class="auth-header">
                <i class="fas fa-user-plus"></i>
                <h1>إنشاء حساب جديد</h1>
                <p>قم بالتسجيل للوصول إلى جميع الدورات والخدمات</p>
            </div>

            <form id="registrationForm" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label>الاسم الأول</label>
                        <div class="input-wrapper">
                            <input type="text" class="form-control" name="first_name" placeholder="أدخل اسمك الأول" required>
                            <i class="fas fa-user"></i>
                            <x-input-error :messages="$errors->get('first_name')" class="mt-2" style="color: red; font-size: 12px;" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label>الاسم الأخير</label>
                        <div class="input-wrapper">
                            <input type="text" class="form-control" name="last_name" placeholder="أدخل اسمك الأخير" required>
                            <i class="fas fa-user"></i>
                            <x-input-error :messages="$errors->get('last_name')" class="mt-2" style="color: red; font-size: 12px;" />
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>البريد الإلكتروني</label>
                    <div class="input-wrapper">
                        <input type="email" class="form-control" name="email" placeholder="example@email.com" required>
                        <i class="fas fa-envelope"></i>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" style="color: red; font-size: 12px;" />
                    </div>
                </div>

                <div class="form-group">
                    <label>رقم الهاتف</label>
                    <div class="input-wrapper">
                        <input type="tel" class="form-control" name="phone" placeholder="+20 123 456 7890" required>
                        <i class="fas fa-phone"></i>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" style="color: red; font-size: 12px;" />
                    </div>
                </div>

                <div class="form-group">
                    <label>كلمة المرور</label>
                    <div class="input-wrapper">
                        <input type="password" class="form-control" name="password" placeholder="أدخل كلمة المرور" required>
                        <i class="fas fa-lock"></i>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" style="color: red; font-size: 12px;" />
                    </div>
                </div>

                <div class="form-group">
                    <label>تأكيد كلمة المرور</label>
                    <div class="input-wrapper">
                        <input type="password" class="form-control" name="password_confirmation" placeholder="أعد إدخال كلمة المرور" required>
                        <i class="fas fa-lock"></i>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" style="color: red; font-size: 12px;" />
                    </div>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="terms" required>
                    <label for="terms">
                        أوافق على <a target="_blank" href="{{ route('terms-and-conditions') }}">الشروط والأحكام</a> و <a target="_blank" href="{{ route('privacy-policy') }}">سياسة الخصوصية</a>
                    </label>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-user-check"></i> إنشاء حساب
                </button>
            </form>



                {{-- <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />

                        <x-text-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password" />

                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <x-primary-button class="ms-4">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form> --}}



                <div class="auth-footer">
                    لديك حساب بالفعل؟ <a href="{{ route('login') }}">تسجيل الدخول</a>
                </div>
            </div>
        </div>

    @endsection
