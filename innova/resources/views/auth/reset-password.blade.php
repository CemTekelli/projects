{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Reset Password') }}
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
                        <form class="login-form"  method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            <div class="login-heading d-flex align-items-center justify-content-center">
                            
                                {{-- <img height="100px" src="{{ asset('img\innovaImg\logo-hd.png') }}" alt="logo"> --}}

                            </div>
                           
                            <div class="input-box pb-5">
                                <div class="single-input-fields">
                                    <label>Email</label>
                                    <input type="text" placeholder="Email address" name="email" value="{{ old('email', $request->email) }}" required autofocus>
                                </div>
                                <div class="single-input-fields">
                                    <label>Password</label>
                                    <input type="password" placeholder="New password" name="password" required autofocus>
                                </div>
                                <div class="single-input-fields">
                                    <label>Confirm Password</label>
                                    <input type="password" placeholder="Confirm password" name="password_confirmation" required autofocus>
                                </div>
      
                          
                            </div>
                            
                            <div class="login-footer justify-content-end">

                                <button class="submit-btn3">Reset Password</button>
                          
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- login Area End -->
    </main>
@endsection