@extends('layouts.app')

@section('content')

<div class="search-history-main">
        <div class="search-history-header">
            <h1>Search History</h1>
        </div>
        <div class="history-search-card">
            <div class="history-search-body col d-flex align-items-center">
                    <div class="input-group">
                        <input type="text" class="form-control smart-search" placeholder="Search Here" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <!-- <span class="input-group-text"><i class="fa-solid fa-microphone"></i></span> -->
                    </div>
                    <div class="search__button">
                        <button type="button" class=" button-smartsearch">Search</button>
                    </div>
            </div>
        </div>
    <div class="search-history-container">
        <div class="card historyCard">
            
            @if ($searchHistory->isEmpty())
                <div class="search-result">
                    <p>Nothing to see here.</p>
                </div>
            @else
                
            @foreach ($searchHistory as $history)
            <div class="search-result">
                <span><b>"{{ $history->search_query }}" | Bible Search</b></span>
            <br><br>
            <span class="search-time">Date and Time Searched: {{ $history->created_at }}</span>
                <button class="search-history-delete-entry">
                    <i class="fa-solid fa-x"></i>
                </button>
            </div>

            @endforeach
               
        </div>
    </div>
</div>

    @endif
@endsection
