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
    #loading-screen {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.8);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}
.loading-animation{
    background: white;
    padding: 5%;
    border-radius: 50px;
    flex-direction: column;
    text-align: center;
    margin: 0 25%;
}
.loading-dots {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100px;
}

.dot {
  width: 10px;
  height: 10px;
  background-color: #333;
  border-radius: 50%;
  margin: 0 5px;
  opacity: 0;
  animation: blink 1s infinite;
}

@keyframes blink {
  0%, 100% {
    opacity: 0;
  }
  50% {
    opacity: 1;
  }
}
    </style>
@extends('layouts.app')

@section('content')    
<main>      
    <div class="homemain__wrapper container animate__animated animate__fadeIn">
        <div class="home__header row">
            <h1 class="welcomeText"> Welcome to <br>Verse Guru! </h1>
        </div>
        <div class="search__module row animate__animated animate__fadeIn">
            <div class="smart_search_card">
                <div class="smart_search_body col d-flex align-items-center">
                    <form id="searchForm" action="{{ route('search.bible') }}" method="POST" class="smartsearchform">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="query" class="form-control smart-search" placeholder="Search Here" aria-label="Recipient's username" aria-describedby="basic-addon2" id="query">
                            <!-- <span class="input-group-text"><i class="fa-solid fa-microphone"></i></span> -->
                        </div>
                        <div class="search__button">
                            <button type="submit" class=" button-smartsearch" id="button-smartsearch">Search</button>
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
<div id="loading-screen">
    <div class="loading-animation">
      <h2>Please wait a moment</h2>
      <div class="loading-dots">
          <div class="dot"></div>
          <div class="dot"></div>
          <div class="dot"></div>
      </div>
        <img src="/img/Eclipse-1s-200px.svg" alt="Loading animation" class="loader-icon">
        <div>
          <h2> Verse of the Day </h2>
           <script src="http://www.verse-a-day.com/js/KJV.js"></script>
        </div>

    </div>
  </div>

@endsection
<script>

function showLoadingScreen() {
  document.getElementById('loading-screen').style.display = 'flex';
}
function hideLoadingScreen() {
  document.getElementById('loading-screen').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    hideLoadingScreen();

    document.getElementById('searchForm').addEventListener('submit', function(event) {
        event.preventDefault(); 

        var userQuery = document.getElementById('query').value;

        showLoadingScreen();
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
});

  
</script>
