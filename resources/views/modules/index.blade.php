@extends('layouts.app')

@section('nav')
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
                                
                                <div class="row">
                                    <h1> LOGIN </h1>
                                </div>
                                <div class="login__form d-flex row my-4">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control username" placeholder="Username">
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="password" class="form-control password" placeholder="Password">
                                    </div>
                                </div>
                                <div class="login__options d-flex col justify-content-around mt-4">
                                    <div class="d-flex col justify-content-start">
                                        <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">
                                        <span style="margin-left: 5px;">Keep me logged in</span>
                                    </div>
                                    <div class="d-flex flex-column-reverse justify-content-end">
                                        <a href="#">Forgot Password?</a>
                                    </div>
                                </div>
                                <div class="login__btn d-flex col justify-content-around align-items-end mt-4">
                                    <div class="d-flex col justify-content-start">
                                        <a href="/createaccount"> Create Account</a>
                                    </div>
                                    <div class="d-flex flex-column-reverse justify-content-end">
                                        <button type="button" class=" loginBtn ml-2">Login</button>
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