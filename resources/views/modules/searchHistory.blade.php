@extends('layouts.app')

@section('content')
<style>
.search-history-delete-all-container{
    display: flex;
    justify-content: flex-end;
    margin: 15px 0;
}
.search-history-delete-all{
    background-color: #ed1a48;
    border: 1px solid;
    color: white;
    padding: 8px 18px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 12px;
    border-radius: 5px;
    margin-right: 10px;
}

.search-history-delete-all:hover{
    background-color: white;
    color: #ed1a48;
    border: 1px solid;
    border-color: black;
    transition: 1s;
}

</style>
<div class="search-history-main">
    <div class="search-history-header">
        <h1>Search History</h1>
    </div>
    <div class="history-search-card">
        <div class="history-search-body col d-flex align-items-center">
            <div class="input-group">
                <input type="text" id="searchHistorySearch" class="form-control smart-search" placeholder="Search Here" aria-label="Recipient's username" aria-describedby="basic-addon2">
                <!-- <span class="input-group-text"><i class="fa-solid fa-microphone"></i></span> -->
            </div>
            <div class="search__button">
                <button type="button" class=" button-smartsearch" name="searchHistoryFilter">Search</button>
            </div>
        </div>
    </div>
    <div class="search-history-container">
        <div class="card historyCard">
            <div>
                <div class="search-history-delete-all-container">
                    <button class="search-history-delete-all" onclick="deleteAllSearchHistory()">
                        Delete All
                    </button>
                </div>
            </div>
            @if ($searchHistory->isEmpty())
                <div class="search-result">
                    <p>Nothing to see here.</p>
                </div>
            @else

            @foreach ($searchHistory as $history)
            <div class="search-result">
                <span  onclick="redirectToBible('{{ $history->search_query }}')"><b>"{{ $history->search_query }}" | Bible Search</b></span>
                <br><br>
                <span class="search-time">Date and Time Searched: {{ $history->created_at }}</span>
                <button class="search-history-delete-entry" onclick="deleteSearchHistory('{{ $history->id }}')">
                    <i class="fa-solid fa-x"></i>
                </button>
            </div>
            @endforeach


            @endif
        </div>
    </div>
</div>

<script>

function deleteSearchHistory(id) {
    if (confirm('Are you sure you want to delete this entry?')) {
        fetch(`/search-history/delete/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
            // Remove the deleted search history entry from the DOM
            document.getElementById('searchResult_' + id).remove();
        })
        .catch(error => {
            console.error('Error deleting search history:', error);
        });
    }
}

function deleteAllSearchHistory() {
    if (confirm('Are you sure you want to delete all search history?')) {
        fetch('/search-history/delete-all', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
            // Remove all search history entries from the DOM
            document.querySelectorAll('.search-result').forEach(element => element.remove());
        })
        .catch(error => {
            console.error('Error deleting search history:', error);
        });
    }
}
    function redirectToBible(searchQuery) {
  // Redirect to the Bible page with the search query parameter
  window.location.href = `/bible?search=${encodeURIComponent(searchQuery)}`;
}


// Get the search query from the URL after redirect
const urlParams = new URLSearchParams(window.location.search);
const searchQuery = urlParams.get('search');

// Check if a search query exists in the URL
if (searchQuery) {
  // Set the search query in the search input field
  document.getElementById('searchInput').value = decodeURIComponent(searchQuery);

  // Call the searchBible() function to perform the search
  searchBible();
}


document.querySelector('.button-smartsearch').addEventListener('click', function() {
  var searchQuery = document.getElementById('searchHistorySearch').value.toLowerCase();
  var searchResults = document.querySelectorAll('.search-result');

  var hasSearchResults = false; // Flag to track if there are any search results

  searchResults.forEach(result => {
    var resultText = result.querySelector('b').textContent.toLowerCase();
    if (resultText.includes(searchQuery)) {
      result.style.display = 'block';
      hasSearchResults = true; // Set the flag to true if a search result is found
    } else {
      result.style.display = 'none';
    }
  });

  if (!hasSearchResults) {
    // Display the "Nothing to see here." message
    var noResultsMessage = document.createElement('div');
    noResultsMessage.classList.add('search-result');
    noResultsMessage.innerHTML = '<p>No results.</p>';
    document.querySelector('.search-history-container').appendChild(noResultsMessage);
  }
});




</script>

@endsection
