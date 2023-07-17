@extends('layouts.app')


<style>
    .password-input {
    position: relative;
}

.password-toggle {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
}

    </style>
@section('content')
<main>
<div class ="main__wrapper container">
            <div class="col">
                <div class="home__header row ">
                    <h1 class="welcomeText"> Welcome to <br>Verse Guru! </h1>
                </div>
            </div>
            <div class="col">
                <div class="login__module row">
                    <div class="card w-75 p-5 shadow-sm ">
                        <div class="row ">
                            <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="row">
                                    <h1> LOGIN </h1>
                                </div>
                                <div class="login__form d-flex row my-4">
                                    <div class="input-group mb-3">
                                        <!-- <input type="text" class="form-control username" placeholder="Username"> -->
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? old('username') }}" required autocomplete="email" autofocus placeholder="E-mail or Username">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    </div>
                                    <div class="input-group mb-3">
                                        <!-- <input type="password" class="form-control password" placeholder="Password"> -->
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                                        <span class="passwordvisibility" onclick="togglePasswordVisibility()">
                                        <i id="togglePasswordIcon" class="fa fa-eye-slash"></i>
                                        </span>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="login__options d-flex col justify-content-around mt-4">
                                    <div class="d-flex col justify-content-start">
                                        <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">
                                        <span style="margin-left: 5px;">Keep me logged in</span>
                                    </div>
                                    <div class="d-flex flex-column-reverse justify-content-end">
                                        <a href="/forgot-password">Forgot Password?</a>
                                    </div>
                                </div>
                                <div class="login__btn d-flex col justify-content-around align-items-end mt-4">
                                    <div class="d-flex col justify-content-start">
                                        <a href="{{ route('register') }}"> Create Account</a>
                                    </div>
                                    <div class="d-flex flex-column-reverse justify-content-end">
                                        <button type="submit" class=" loginBtn ml-2"> {{ __('Login') }}</button>
                                        <!-- @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                        @endif -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</main>
@endsection
