@extends('layouts.app')
<style>

</style>
@section('content')
    <div class="profile-main">
        <div class="spacer-profile"></div>
        <div class="profile-container">
            <h1>Profile</h1>
            <div class="profile-card animate__animated animate__fadeInDown">
                <div class="profile-content">
                    <div class="profile-picture">
                        @if (auth()->user()->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture">
                        @else
                            <img src="{{ asset('storage/profile-pictures/defaultPFP.png') }}" alt="Default Profile Picture">
                        @endif
                        <form method="POST" action="{{ route('upload-profile-picture') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="upload-profile-pic">
                                <input type="file" name="profile_picture" class="uploadpfp-input profile-edit ">
                                <button type="submit">Upload</button>
                            </div>
                        </form>
                    </div>
                    <div class="profile-right">
                        <h2>My Profile</h2>
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="profile-right-top">
                                <span>Name</span>
                                <div class="profile-data">
                                    <input type="text" name="name" value="{{ $user->name }}" >
                                </div>
                            </div>

                            <div class="profile-right-bottom">
                                <div class="profile-data-label data-username">
                                    <span>Username</span>
                                    <div class="profile-data-bottom">
                                        <input type="text" name="username" value="{{ $user->username }}">
                                    </div>
                                </div>
                                <div class="profile-data-label-email">
                                    <span>Email</span>
                                    <div class="profile-data-bottom data-email">
                                        <input type="email" name="email" value="{{ $user->email }}" >
                                    </div>
                                </div>
                            </div>

                            <div class="profile-edit">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Input your password here to save changes">        
                            <span class="passwordvisibility" onclick="togglePasswordVisibility()">
                             <i id="togglePasswordIcon" class="fa fa-eye-slash"></i>
                            </span>

                            @error('password')
                                <span class="invalid-feedback" role="alert" style="z-index:1;">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                                <button type="submit">Save</button>
                            </div>
                            <div class="resetPass">
                                <a href="{{ route('password.request') }}">Reset Password</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="spacer"></div>

@endsection
