@extends('layouts.app')


@section('content')
<main>
<div class ="main__wrapper container">
            <div class="col">
                <div class="home__header row ">
                    <h1 class="welcomeText"> Welcome to <br>Verse Guru! </h1>
                </div>
            </div>
            <div class="col">
                <div class="signup__module row">
                    <div class="card w-100 p-5 shadow-sm ">
                        <div class="row ">
                            <div class="card-body createAccount__container">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="row">
                                    <h1> SIGN UP </h1>
                                </div>
                                <div class="signup__form d-flex row ">
                                    <div class="input-group mb-3">
                                        <!-- <input type="text" class="form-control username" placeholder="Full Name"> -->
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Full Name">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                    <div class="d-flex row">
                                        <div class="col p-1">
                                            <div class="input-group mb-3">
                                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required placeholder="Username">
                                                    @error('username')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="col p-1">
                                            <div class="input-group mb-3">
                                                <!-- <input type="text" class="form-control password" placeholder="Email"> -->
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex row">
                                        <div class="col p-1">
                                            <div class="input-group mb-3">
                                                <!-- <input type="password" class="form-control password" placeholder="Password"> -->
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col p-1">
                                            <div class="input-group mb-3">
                                                 <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="signup__btn d-flex col justify-content-around align-items-end mt-4">
                                        <div class="d-flex col justify-content-start">
                                            <a href="/"> Already have an account?</a>
                                        </div>
                                        <div class="d-flex flex-column-reverse justify-content-end">
                                            <button type="Submit" class=" signupBtn ml-2">{{ __('Register') }}</button>
                                        </div>
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
