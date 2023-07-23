@extends('layouts.app')
<style>
.bookmarks-main{
    display: flex;
    align-items: center;
    align-content: center;
    flex-direction: column;
}
.bookmarks-container{
    margin: 2% !important;
    width: 70%;
}
.bookmarks-header{
    margin: 5px 0px;
    margin-top: 50px;
    margin-right: 40%;
    color: white;
}
.bookmarks-header h1{
    font-family: 'Playfair Display', serif !important;
    font-size: 80px;
    margin-bottom: 50px;
}

.bookmarkCard{
    padding: 25px;
}
.bookmarks-results{
    overflow-y: scroll;
    height: 535px;
    display: flex;
    flex-direction: column;
}
.bookmarks-search-card{
    background: white;
    padding: 20px;
    border-radius: 15px;
    margin-left: 50%;
  }
.bookmarks-delete-all-container{
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
}
</style>
@section('content')

<div class="bookmarks-main">
    <div class="bookmarks-header">
        <h1>Bookmarks</h1>
    </div>
    <div class="bookmarks-search-card">
        <div class="bookmarks-search-body col d-flex align-items-center">
            <div class="input-group">
                <input type="text" id="bookmarksSearch" class="form-control smart-search" placeholder="Search Bookmarks" aria-label="Recipient's username" aria-describedby="basic-addon2">
            </div>
            <div class="search__button">
                <button type="button" class="button-smartsearch" name="searchBookmarks">Search</button>
            </div>
        </div>
    </div>
    <div class="bookmarks-container">
        <div class="card bookmarkCard">
            <div>
                <div class="bookmarks-delete-all-container">
                    <button class="bookmarks-delete-all" onclick="deleteAllBookmarks()">
                        Delete All
                    </button>
                </div>
            </div>
            <div class="bookmarks-results">
                @if ($bookmarks->isEmpty())
                    <div class="bookmark-result">
                        <p>No bookmarks added yet.</p>
                    </div>
                @else
                    @foreach ($bookmarks as $bookmark)
                    <div class="bookmark-result">
                        <span><b>{{ $bookmark->verse }}</b></span>
                        <br><br>
                        <span class="bookmark-text">{{ $bookmark->verse_text }}</span>
                        <button class="bookmark-delete-entry" onclick="deleteBookmark('{{ $bookmark->id }}')">
                            <i class="fa-solid fa-x"></i>
                        </button>
                        <div>
                            
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<script>
function deleteBookmark(id) {
        if (confirm('Are you sure you want to delete this bookmark?')) {
            fetch(`/bookmarks/delete/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })
            .then(response => response.json())
            .then(data => {
                console.log(data.message);
                // Remove the deleted bookmark from the DOM
                document.getElementById('bookmarkResult_' + id).remove();
            })
            .catch(error => {
                console.error('Error deleting bookmark:', error);
            });
        }
    }
    
    function deleteAllBookmarks() {
    if (confirm('Are you sure you want to delete all bookmarks?')) {
        fetch('/bookmarks/delete-all', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
            // Remove all bookmarks from the DOM
            document.querySelectorAll('.bookmark-result').forEach(element => element.remove());
        })
        .catch(error => {
            console.error('Error deleting bookmarks:', error);
        });
    }
}





// function redirectToBible(selectedBookmark) {
//     var valueofClick = self.value;
//     console.log('valueofClick: 'valueofClick);
// //   window.location.href = `/bible?search=${encodeURIComponent(selectedBookmark)}`;
// }

function handleBookmarkResultClick(event) {
  var bookmarkContent = event.currentTarget.querySelector('b').textContent;
  var parts = bookmarkContent.split('.');
  var extractedChapter = parts.slice(0, 2).join('.');
  window.location.href = `/bible?chapter=${encodeURIComponent(extractedChapter)}`;
}

// Get all the bookmark result elements
var bookmarkResults = document.querySelectorAll('.bookmark-result');

// Add click event listener to each bookmark result element
bookmarkResults.forEach(result => {
  result.addEventListener('click', handleBookmarkResultClick);
});


const urlParams = new URLSearchParams(window.location.search);
const searchQuery = urlParams.get('search');

if (searchQuery) {
  // Set the search query in the search input field
  document.getElementById('searchInput').value = decodeURIComponent(searchQuery);

  // Call the searchBible() function to perform the search
  searchBible();
}


document.querySelector('#bookmarksSearch').addEventListener('input', function() {
    var searchQuery = document.getElementById('bookmarksSearch').value.toLowerCase();
    var bookmarkResults = document.querySelectorAll('.bookmark-result');

    var hasBookmarkResults = false; // Flag to track if there are any bookmark results

    bookmarkResults.forEach(result => {
        var resultText = result.querySelector('span').textContent.toLowerCase();
        if (resultText.includes(searchQuery)) {
            result.style.display = 'block';
            hasBookmarkResults = true; // Set the flag to true if a bookmark result is found
        } else {
            result.style.display = 'none';
        }
    });

    if (!hasBookmarkResults) {
        // Display the "No bookmarks added yet." message
        var noResultsMessage = document.createElement('div');
        noResultsMessage.classList.add('bookmark-result');
        noResultsMessage.innerHTML = '<p>No bookmarks found.</p>';
        document.querySelector('.bookmarks-container').appendChild(noResultsMessage);
    }
});



</script>

@endsection
