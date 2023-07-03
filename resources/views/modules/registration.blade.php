@extends('layouts.layout')

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
                    <div class="card w-75 p-5 shadow-sm ">
                        <div class="row ">
                            <div class="card-body createAccount__container">
                                <div class="row">
                                    <h1> SIGN UP </h1>
                                </div>
                                <div class="signup__form d-flex row ">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control username" placeholder="Full Name">
                                    </div>
                                    <div class="d-flex row">
                                        <div class="col p-1">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control password" placeholder="Username">
                                            </div>
                                        </div>
                                        <div class="col p-1">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control password" placeholder="Email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex row">
                                        <div class="col p-1">
                                            <div class="input-group mb-3">
                                                <input type="password" class="form-control password" placeholder="Password">
                                            </div>
                                        </div>
                                        <div class="col p-1">
                                            <div class="input-group mb-3">
                                                <input type="password" class="form-control password" placeholder="Re-enter Password">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="signup__btn d-flex col justify-content-around align-items-end mt-4">
                                        <div class="d-flex col justify-content-start">
                                            <a href="/"> Already have an account?</a>
                                        </div>
                                        <div class="d-flex flex-column-reverse justify-content-end">
                                            <button type="button" class=" signupBtn ml-2">Sign Up</button>
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
