
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


            <form id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label>البريد الإلكتروني</label>
                    <div class="input-wrapper">
                        <input type="email" class="form-control" placeholder="example@email.com" name="email" :value="old('email')" required autofocus autocomplete="username">
                        <i class="fas fa-envelope"></i>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" style="color: red; font-size: 12px;" />
                    </div>
                </div>

                <div class="form-group">
                    <label>كلمة المرور</label>
                    <div class="input-wrapper">
                        <input type="password" class="form-control" placeholder="أدخل كلمة المرور" name="password" required autocomplete="current-password">
                        <i class="fas fa-lock"></i>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" style="color: red;" />
                    </div>
                </div>

                <div class="form-options">
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">تذكرني</label>
                    </div>
                    <a href="#" class="forgot-password">نسيت كلمة المرور؟</a>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-sign-in-alt"></i> تسجيل الدخول
                </button>
            </form>
            <div class="auth-footer">
                ليس لديك حساب؟ <a href="{{ route('register') }}">إنشاء حساب جديد</a>
            </div>



    {{-- <form method="POST" id="loginForm" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form> --}}
</div>
</div>
</main>
@endsection
