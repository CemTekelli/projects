{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-3">
                    {{ __('Log in') }}
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
                     
                        <form class="login-form"  method="POST" action="{{ route('login') }}">
                            @csrf
                            <!-- Login Heading -->
                            <div class="login-heading d-flex align-items-center justify-content-center">
                                <a href="{{ route('home') }}">
                                    <img height="110px" src="{{ asset('img\innovaImg\logo-hd.png') }}" alt="logo">
                                
                                </a>
                            
                                <span class="m-0">Innova Furniture</span>
                                {{-- <p>Login</p> --}}
                            </div>
                            <!-- Single Input Fields -->
                            <div class="input-box">
                                <div class="single-input-fields">
                                    <label>Email</label>
                                    <input  type="text" placeholder="Email address" name="email" value="{{ old('email') }}" required autofocus class="@error('email') is-invalid @enderror">
                                    @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                
                                </div>
                                <div class="single-input-fields">
                                    <label>Password</label>
                                    
                                    <input   type="password" placeholder="Enter Password"
                                        name="password"
                                        required autocomplete="current-password" class="@error('password') is-invalid @enderror">
                                        @error('password')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                       
                                </div>
                                <div class="single-input-fields login-check">
                                    <input type="checkbox" id="remember_me"  name="remember">
                                    <label for="remember_me">Remember me</label>

                                 
                    
                                    @if (Route::has('password.request'))
                                    <a class="f-right" href="{{ route('password.request') }}">
                                        Forgot your password?
                                    </a>
                                @endif
                                </div>
                                {{-- @if ($errors->any())
                                    <div  class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{  $error  }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif --}}
                            </div>
                            <!-- form Footer -->
                            <div class="login-footer ">
                                <p>Don’t have an account? <a href="{{ route('register') }}">Sign Up</a>  here</p>

                                <button class="submit-btn3">Login</button>
                          
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- login Area End -->
    </main>
@endsection