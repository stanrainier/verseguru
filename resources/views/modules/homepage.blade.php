<style>
    pre {
        font-family: 'Montserrat', sans-serif;
        font-size: 12px;
    }
    .smart_search-output-container{
        display:block;
    }
    .output-container{
    border: 1px solid #ccc;
    padding: 60px;
    min-height: 500px;
    background: #d7d7d7f2;
    margin: 100px 0px !important;
    font-size: 20px;
    border-radius: 10px;
    }
    </style>
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
                    <form id="searchForm" action="{{ route('search.bible') }}" method="POST" class="smartsearchform">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="query" class="form-control smart-search" placeholder="Search Here" aria-label="Recipient's username" aria-describedby="basic-addon2" id="query">
                            <!-- <span class="input-group-text"><i class="fa-solid fa-microphone"></i></span> -->
                        </div>
                        <div class="search__button">
                            <button type="submit" class=" button-smartsearch">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="smart_search-output-container">
            @if (isset($output) && is_string($output))
            <div class="output-container">
                <h3>Results for: <strong>{{ $userQuery}} </strong></h3>
                <pre style="font-family: 'Montserrat', sans-serif;
                font-size: 15px;">{!! $output !!}
                </pre>
                <!-- <div>{!! $output !!}</div> -->
            </div>
            @endif
            </div>
        </div>
    </div>
</main>
@endsection
<script>
    document.getElementById('searchForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting normally

        var userQuery = document.getElementById('query').value;

        // You can add any conditions here based on userQuery if you want to trigger both actions conditionally

        // Submit the form for search.bible
        this.submit();

        // Additional action for smartsearch route using fetch API
        fetch('/smartsearch', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ query: userQuery }),
        })
        .then(response => response.json())
        .then(data => {
            // Handle the response data from the smartsearch route
            console.log(data);
        })
        .catch(error => {
            console.error('Error with smartsearch:', error);
        });
    });
</script>
