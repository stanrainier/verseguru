@extends('layouts.app')

@section('content')
<main>
<div class="container">
    <div class="verification-container">
        <div class="row justify-content-center">
            <div class="col-md-8">                
                <div class="card cardVerify">
                    <div class="card-header ">
                    <img src="/img/brand/logoMain.svg" height="120px" width="120px">
                    </div>
                    <div class="card-header ">
                        <strong>{{ __('Verify Your Email Address') }}<strong></div>
                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif

                        {{ __('We have sent an email to [email] to verify your account on Verse Guru.') }}
                        {{ __('If you did not receive the email') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>

@endsection
