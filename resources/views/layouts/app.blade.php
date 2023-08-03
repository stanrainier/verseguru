<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Verse Guru</title>

    <!-- Fonts -->
    <!-- <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> -->

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="icon" href="/img/brand/logo-color.svg" >
    <!-- Styles  -->
        <!-- bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
            <!-- Montserrat -->
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
            <!-- Playfair Display -->
                <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Playfair+Display&display=swap" rel="stylesheet">
    <!-- Icons -->
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Sweetalert-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="/css/app.css">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <!-- Axios  -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('js/global.js') }}"></script>

  </head>

<body>

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
            <img src="{{ asset('img/brand/logoMain.svg') }}" alt="Logo" class="verseguruLogo">

                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Verse Guru') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>
                    <!-- Right Side Of Navbar -->
                    @php
                        $currentUrl = url()->current();
                    @endphp

                    <ul class="navbar-nav">
                    @php
                        $currentUrl = url()->current();
                    @endphp
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login') && $currentUrl != url('/email/verify'))
                                <li class="nav-item">
                                    <span class="nav-linkhide" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register') && $currentUrl != url('/email/verify'))
                                <li class="nav-item">
                                    <span class="nav-linkhide" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            @if (auth()->check() && auth()->user()->hasVerifiedEmail())
                            <div class="navbar__item m-3 @if($currentUrl === url('/home')) active @endif">
                                    <a href="/" class="formatlink"><span> HOME </span></a>
                                </div>
                                <div class="navbar__item m-3 @if($currentUrl === url('/bible')) active @endif">
                                    <a href="/bible" class="formatlink"><span> BIBLE </span></a>
                                </div>
                                <div class="navbar__item m-3 @if($currentUrl === url('/bookmarks')) active @endif">
                                    <a href="/bookmarks" class="formatlink"><span> BOOKMARKS </span></a>
                                </div>
                                <div class="navbar__item m-3 @if($currentUrl === url('/history')) active @endif">
                                    <a href="/history" class="formatlink"><span> HISTORY </span></a>
                                </div>
                                <li class="nav-item dropdown m-auto ">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle " href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="{{ Auth::user()->name }}" class="pfp" >
                                        {{ Auth::user()->name }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile') }}">{{ __('My Profile') }}</a>
                                    <a class="dropdown-item" href="/bookmarks">{{ __('Bookmarks') }}</a>
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @else
                                @if (Route::has('login') && $currentUrl != url('/email/verify'))
                                    <li class="nav-item">
                                        <span class="nav-linkhide" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register') && $currentUrl != url('/email/verify'))
                                    <li class="nav-item">
                                        <span class="nav-linkhide" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @endif
                            
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <main>
            @yield('content')
    </main>
    <footer>
    <div class="footer d-flex">
            <div class="contact__container row">
                <div class="contact col ml-5">
                    <h1>Contact Us</h1>
                    <div class="contact-inputs1">
                        <input type="text" placeholder="Name" class="contact__footer"></input>
                        <input type="text" placeholder="Email" class="contact__footer"></input>
                    </div>
                    <div class ="contact-inputs2">
                        <input type="text" placeholder="Message" class="contact__footer__message"></input>
                    </div>
                    <button class="contactBtn">Submit</button>
                </div>
                <div class="logo col">
                    <div class="logo__content">
                        <img src="/img/brand/logoMain.svg"  alt="Logo" >
                    </div>  
                </div>  
                <div class=" links__container col">
                    <div class="links col">
                        <h1>Links</h1>
                        <div class="links_contents mb-5">
                            <div class="d-flex col justify-content-around">
                                <div class="row">
                                    <div class="row mt-4">
                                        <span><a href="/home">HOME</a></span>
                                    </div>
                                    <div class="row mt-4">
                                        <span><a href="{{ route('bible') }}">BIBLE</a></span>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="row mt-4">
                                        <span><a href="{{ route('aboutus') }}">ABOUT US</a></span>
                                    </div>
                                    <div class="row mt-4">
                                        <span><a href="/bookmarks">BOOKMARKS</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="connectwithus col">
                        <h1>Connect With Us</h1>
                        <div class="row">
                            <div class="footer__icons">
                                <i class="fa-sharp fa-regular fa-envelope"></i>
                            </div>
                            <!-- <div class="footer__icons">
                                <i class="fa-brands fa-facebook"></i>
                            </div> -->
                            <div class="footer__icons">
                                <i class="fa-brands fa-twitter"></i>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
    </div>
    <div class="copyright">
        <span>© 2023 ALL RIGHTS RESERVED  ROKESTA</span>
    </div>
    </footer>
</body>
<script>
      function disableAutocomplete() {
    const inputElements = document.getElementsByTagName('input');
    for (let i = 0; i < inputElements.length; i++) {
      inputElements[i].setAttribute('autocomplete', 'off');
    }
  }

  // Call the function to disable autocomplete on page load
  disableAutocomplete();

    </script>
</html>

