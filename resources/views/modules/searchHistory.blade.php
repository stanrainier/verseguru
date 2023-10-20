@extends('layouts.app')

@section('content')
<div class="search-history-main">
    <div class="spacer_bible"></div>
    <div class="history-search-card animate__animated animate__fadeInRight">
        <div class="history-search-body col d-flex align-items-center">
            <div class="input-group">
                <input type="text" id="searchHistorySearch" class="form-control smart-search" placeholder="Search Here" aria-label="Recipient's username" aria-describedby="basic-addon2">
                <!-- <span class="input-group-text"><i class="fa-solid fa-microphone"></i></span> -->
            </div>
            <div class="search__button">
                <button type="button" class="button-smartsearch" name="searchHistoryFilter">Search</button>
            </div>
        </div>
    </div>
    <div class="search-history-container animate__animated animate__fadeInUp">
        <div class="card historyCard">
            <div>
                <div class="search-history-delete-all-container">
                <button class="search-history-delete-all" id="delete-single">
                        Delete Selected
                    </button>
                    <button class="search-history-delete-all" onclick="deleteAllSearchHistory()">
                        Delete All
                    </button>
                </div>
            </div>
            <div class="search-history-results">
                @if ($searchHistory->isEmpty() && $smartsearchHistory->isEmpty())
                    <div class="search-result">
                        <p>Nothing to see here.</p>
                    </div>
                @else
                @php
                    $mergedHistory = $searchHistory->concat($smartsearchHistory);
                    $sortedHistory = $mergedHistory->sortByDesc('created_at');
                @endphp


                @foreach ($sortedHistory as $history)
                    <div class="search-result">
                        @if ($history instanceof \App\Models\SearchHistory)
                        <label class="search-history-checkbox">
                            <input type="checkbox" class="checkbox" value="{{ $history->id }}">
                            <span class="search-history-query"><b>"{{ $history->search_query }}" | Bible Search</b></span>
                        </label>
                        @elseif ($history instanceof \App\Models\SmartSearchHistory)
                        <label class="search-history-checkbox">
                            <input type="checkbox" class="checkbox" value="{{ $history->id }}">
                            <span class="search-history-query"><b>"{{ $history->search_query }}" | Smart Search</b></span>
                        </label>
                        @endif
                        <br><br>
                        <span class="search-time">Date and Time Searched: {{ $history->created_at }}</span>
                    </div>
                @endforeach

                @endif
            </div>
        </div>
    </div>
</div>
<script>

document.getElementById('delete-single').addEventListener('click', deleteSelectedSearchHistory);

function deleteSelectedSearchHistory() {
    var selectedIds = [];
    var checkboxes = document.querySelectorAll('.checkbox:checked');
    
    checkboxes.forEach(checkbox => {
        selectedIds.push(checkbox.value);
    });

    if (selectedIds.length === 0) {
        Swal.fire(
            'No Selection',
            'Please select entries to delete.',
            'warning'
        );
        return;
    }

    Swal.fire({
        title: 'Confirm Deletion',
        text: 'Are you sure you want to delete selected entries?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete them!'
    }).then((result) => {
        if (result.isConfirmed) {
            const csrfToken = '{{ csrf_token() }}';
            const deleteOptions = {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
            };
            const deleteUrls = selectedIds.map(id => `/search-history/delete/${id}`);

            Promise.all(deleteUrls.map(url => fetch(url, deleteOptions)))
                .then(responses => Promise.all(responses.map(response => response.json())))
                .then(dataArray => {
                    selectedIds.forEach(id => {
                        var searchResult = document.getElementById('searchResult_' + id);
                        if (searchResult) {
                            searchResult.remove();
                        }
                    });
                    Swal.fire({
                    title: 'Deleted!',
                    text: 'Selected entries have been deleted.',
                    icon: 'success',
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
                })
                .catch(error => {
                    console.error('Error deleting search history:', error);
                    Swal.fire(
                        'Error',
                        'An error occurred while deleting entries.',
                        'error'
                    );
                });
        }
    });
}



function deleteAllSearchHistory() {
    Swal.fire({
        title: 'Confirm Deletion',
        text: 'Are you sure you want to delete all search history?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete all!'
    }).then((result) => {
        if (result.isConfirmed) {
            const csrfToken = '{{ csrf_token() }}';
            const deleteOptions = {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
            };
            const deleteUrls = ['/search-history/delete-all', '/smartsearch-history/delete-all'];

            Promise.all(deleteUrls.map(url => fetch(url, deleteOptions)))
                .then(responses => Promise.all(responses.map(response => response.json())))
                .then(dataArray => {
                    document.querySelectorAll('.search-result').forEach(element => element.remove());
                    Swal.fire(
                        'Deleted!',
                        'All search history has been deleted.',
                        'success'
                    );
                })
                .catch(error => {
                    console.error('Error deleting search history:', error);
                    Swal.fire(
                        'Error',
                        'An error occurred while deleting search history.',
                        'error'
                    );
                });
        }
    });
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
