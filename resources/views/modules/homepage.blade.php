@extends('layouts.app')

@section('content')    
<main>      
    <div class="homemain__wrapper container">
        <div class="home__header row">
            <h1 class="welcomeText"> Welcome to <br>Verse Guru! </h1>
        </div>
        <div class="search__module row">
            <div class="smart_search_card">
                <div class="smart_search_body col d-flex align-items-center">
                    <form id="searchForm" action="{{ route('smartsearch') }}" method="POST" class="smartsearchform">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="query" class="form-control smart-search" placeholder="Search Here" aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <!-- <span class="input-group-text"><i class="fa-solid fa-microphone"></i></span> -->
                        </div>
                        <div class="search__button">
                            <button type="submit" class=" button-smartsearch">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
