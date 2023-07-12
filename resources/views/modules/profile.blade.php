@extends('layouts.app')
<style>
</style>
@section('content')
    <div class="profile-main">
        <div class="profile-container">
            <h1>Profile</h1>
            <div class="profile-card">
                <div class="profile-content">
                    <div class="profile-picture">
                        @if (auth()->user()->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture">
                        @else
                            <img src="{{ asset('storage/profile-pictures/defaultPFP.png') }}" alt="Default Profile Picture">
                        @endif
                        <form method="POST" action="{{ route('upload-profile-picture') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="profile_picture" class="profile-edit">
                            <button type="submit">Upload</button>
                        </form>
                    </div>
                    <div class="profile-right">
                        <h2>My Information</h2>
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
                                <input type="password" name="password" placeholder="Enter your password to save changes" required>
                                <button type="submit">Save</button>
                            </div>
                            <a href="{{ $resetUrl }}">Reset Password</a>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
