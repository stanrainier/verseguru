@extends('layouts.app')
<style>



</style>
@section('content')

    <div class="profile-main">
        <div class="profile-container">
            <h1> Profile </h1>
            <div class="profile-card">
                <div class="profile-content">
                    <div class="profile-picture">
                        @if (auth()->user()->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture">
                        @else
                        @endif
                        <form method="POST" action="{{ route('upload-profile-picture') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="profile_picture" class="profile-edit">
                            <button type="submit">Upload</button>
                        </form>
                    </div>
                    <div class="profile-right">
                        <h2> My Information </h2>
                        <div class="profile-right-top">
                            <span> Name </span>
                                <div class="profile-data">
                                    <input placeholder="{{ $user->name }}"></p>
                                </div>
                        </div>
                        <div class="profile-right-bottom">
                            <div class="profile-data-label data-username">
                                <span> Username </span>
                                    <div class="profile-data-bottom">
                                        <input placeholder="{{ $user->username }}"></p>
                                    </div>
                            </div>
                            <div class="profile-data-label-email">
                                <span> Email </span>
                                    <div class="profile-data-bottom data-email">
                                        <input placeholder="{{ $user->email }}"></input>
                                    </div>
                            </div>
                        </div>
                            <div class="profile-edit">
                                <button> Change Password </button>
                                <button> Save </button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Additional user profile information and UI components -->
@endsection