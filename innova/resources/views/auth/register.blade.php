{{-- <x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout> --}}

@extends('layouts.index')
@section('content')
<main class="login-bg" style="height: auto !important">
  
    <!-- Register Area Start -->
    <div class="register-form-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="register-form text-center">
                        <!-- Login Heading -->
                        <div class="register-heading">
                            <div class="d-flex justify-content-center align-items-center">
                                <a href="{{ route('home') }}">
                                    <img height="110px" src="{{ asset('img\innovaImg\logo-hd.png') }}" alt="logo">
                                </a>
                                <span class="m-0">Sign Up</span>
                            </div>
                            <p>Create your account </p>
                        </div>
                        <!-- Single Input Fields -->
                        <form method="POST" action="{{ route('register') }}" class="input-box">
                            @csrf
                            <div class="row">
                                <div class="single-input-fields col-sm-12 col-md-6">
                                    <label>Name</label>
                                    <input name="name" type="text" value="{{ old('name') }}" placeholder="Enter name" class="@error('name') is-invalid @enderror">
                                    @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="single-input-fields col-sm-12 col-md-6">
                                    <label>First name</label>
                                    <input name="firstname" type="text" value="{{ old('firstname') }}" placeholder="Enter first name" class="@error('firstname') is-invalid @enderror">
                                    @error('firstname')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="row">
                                <div class="single-input-fields col-sm-12 col-md-6">
                                    <label>City</label>
                                    <input name="city" type="text" value="{{ old('city') }}" placeholder="Merchtem ?" class="@error('city') is-invalid @enderror">
                                    @error('city')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="single-input-fields col-sm-12 col-md-6">
                                    <label>Postal code </label>
                                    <input name="postalcode" type="text" value="{{ old('postalcode') }}" placeholder="1785 ?" class="@error('postalcode') is-invalid @enderror">
                                    @error('postalcode')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>
                            <div class="single-input-fields">
                                <label>Email Address</label>
                                <input name="email" type="email" value="{{ old('email') }}" placeholder="Enter email address" class="@error('email') is-invalid @enderror">
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="single-input-fields">
                                <label>Password</label>
                                <input name="password" type="password"  placeholder="Enter Password">
                                @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="single-input-fields">
                                <label>Confirm Password</label>
                                <input name="password_confirmation" type="password" placeholder="Confirm Password">
                            </div>
                            <!-- form Footer -->
                            <div class="register-footer">
                                <p> Already have an account? <a href="{{ route('login') }}"> Login</a> here</p>
                                {{-- <p> By creating an account, you agree to Innova Furniture Conditions of Use </p> --}}
                                <button class="submit-btn3">Sign Up</button>
                            </div>
                        </form>
                        <p>By creating an account, you agree to Innova Furniture <button type="button" class="condition-btn" data-toggle="modal" data-target=".bd-example-modal-lg">Conditions of Use</button> </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Register Area End -->
</main>
@include('partials.modal-condition')

@endsection