@extends('layouts.app')
<style>
.checkbox{
    width:25px;
    height:19px;
    margin: 0 5px -4px 0;
}
.select-all{
    display:none;
    border-radius: 5px;
    border-width: 1px;
    border-color: gray;
    padding: 20px; 
    margin: 10px;
    justify-content: space-between;
    background: #ed1a48;
}
</style>    
@section('content')
<div class="search-history-main">
    <div class="spacer_bible"></div>
    <div class="history-search-card animate__animated animate__fadeInRight">
        <div class="history-search-body col d-flex align-items-center">
            <div class="input-group">
                <input type="text" id="searchHistorySearch" class="form-control smart-search" placeholder="Search Here" aria-label="Recipient's username" aria-describedby="basic-addon2">
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
                <button class="bookmarks-delete-all" id="delete-button">
                    <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="select-all" id="select-all">
                <label class="bookmark-checkbox">
                <input type="checkbox" class="checkbox" id="master-checkbox" style="margin-left 2px;"> <!-- Add a master checkbox -->
                <span><strong>Select all</strong></span>
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
                        <label class="search-history-checkbox">
                            <input type="checkbox" class="checkbox" value="{{ $history->id }}">
                            @if ($history instanceof \App\Models\SearchHistory)
                                <span class="search-history-query"><b>"{{ $history->search_query }}" | Bible Search</b></span>
                            @elseif ($history instanceof \App\Models\SmartSearchHistory)
                                <span class="search-history-query"><b>"{{ $history->search_query }}" | Smart Search</b></span>
                            @endif
                        </label>
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
    // Add an event listener to the master checkbox
    $(document).ready(function() {
        // Add a change event handler to the master checkbox
        $('#master-checkbox').change(function() {
            var isChecked = $(this).prop('checked');
            $('.checkbox').prop('checked', isChecked);
        });
    });

    // ... (previous JavaScript code) ...
    var selectDiv = document.getElementsByClassName('select-all')[0]; // Assuming there's only one element with the class 'select-all'

    function toggleSelect() {
        if (selectDiv.style.display === 'none') {
            selectDiv.style.display = 'flex';
        } else {
            selectDiv.style.display = 'none';
        }
    }
    document.getElementById('delete-button').addEventListener('mouseenter', toggleSelect);
    document.getElementById('delete-button').addEventListener('click', deleteSelectedHistory);


function deleteSelectedHistory() {
    var selectedIds = [];
    var checkboxes = document.querySelectorAll('.checkbox:checked');

    checkboxes.forEach(checkbox => {
        selectedIds.push(checkbox.value);
    });

    if (selectedIds.length === 0) {
        Swal.fire(
            'No Selection',
            'Please select bookmarks to delete.',
            'warning'
        );
        return;
    }
    Swal.fire({
        title: 'Confirm Deletion',
        text: 'Are you sure you want to delete selected bookmarks?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete them!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Update the route to use the 'deleteSelectedHistory' route
            fetch("{{ route('searchHistory.deleteSelected') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ ids: selectedIds })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data.message);
                    // Remove the deleted bookmarks from the DOM
                    selectedIds.forEach(id => {
                        var bookmarkResult = document.querySelector(`.bookmark-result[data-id="${id}"]`);
                        if (bookmarkResult) {
                            bookmarkResult.remove();
                        }
                    });
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'Selected bookmarks have been deleted.',
                        icon: 'success',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                })
                .catch(error => {
                    console.error('Error deleting bookmarks:', error);
                    Swal.fire(
                        'Error',
                        'An error occurred while deleting bookmarks.',
                        'error'
                    );
                });
        }
    });
}


//.search-history-query

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


//REDIRECT TO BIBLE SEARCH
document.querySelectorAll('.search-history-query b').forEach(bElement => {
    bElement.addEventListener('dblclick', function() {
        // Get the text of the <b> element, remove double quotes, and split by '|'
        const searchQuery = this.textContent.replace(/"/g, '').split('|')[0].trim();
        // Call the redirectToBible function
        redirectToBible(searchQuery);
    });
});

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
