{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout> --}}

@extends('layouts.index')
@section('content')
    <main class="login-bg">
        <!-- login Area Start -->
        <div class="login-form-area">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-8">
                        <form class="login-form"  method="POST" action="{{ route('password.email') }}">
                            @csrf
                            
                            <div class="login-heading d-flex align-items-center justify-content-center">
                            
                                Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.

        
                            </div>
                           
                            <div class="input-box pb-5">
                                <div class="single-input-fields">
                                    <label>Email</label>
                                    <input type="text" placeholder="Email address" name="email" value="{{ old('email') }}" required autofocus>
                                </div>
      
                          
                            </div>
                            
                            <div class="login-footer">
                                <p><a href="{{ route('login') }}"> Login ?</a> here</p>

                                <button class="submit-btn3">Email Password Reset Link</button>
                          
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- login Area End -->
    </main>
@endsection