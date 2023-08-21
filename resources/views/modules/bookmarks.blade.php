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
.bookmark-result:hover{
    cursor:pointer;
    background: rgb(246,246,243) !important;
    background: -moz-linear-gradient(93deg, rgba(246,246,243,1) 0%, rgba(255,198,5,1) 60%, rgba(250,255,195,1) 100%) !important;
    background: -webkit-linear-gradient(93deg, rgba(246,246,243,1) 0%, rgba(255,198,5,1) 60%, rgba(250,255,195,1) 100%) !important;
    background: linear-gradient(93deg, rgba(246,246,243,1) 0%, rgba(255,198,5,1) 60%, rgba(250,255,195,1) 100%) !important;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#f6f6f3",endColorstr="#faffc3",GradientType=1);
    transition: 1s !important;
}
.checkbox{
    width:25px;
    height:19px;
    margin: 0 5px -4px 0;
}
</style>
@section('content')

<div class="bookmarks-main">
<div class="spacer_bible"></div>
    <div class="bookmarks-search-card animate__animated animate__fadeInRight">
        <div class="bookmarks-search-body col d-flex align-items-center">
            <div class="input-group">
                <input type="text" id="bookmarksSearch" class="form-control smart-search" placeholder="Search Bookmarks" aria-label="Recipient's username" aria-describedby="basic-addon2">
            </div>
            <div class="search__button">
                <button type="button" class="button-smartsearch" name="searchBookmarks">Search</button>
            </div>
        </div>
    </div>
    <div class="bookmarks-container animate__animated animate__fadeInUp">
        <div class="card bookmarkCard">
            <div>
                <div class="bookmarks-delete-all-container">
                    <button class="bookmarks-delete-all" id="delete-single">
                        Delete Selected
                    </button>
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
                    <?php $sortedBookmarks = $bookmarks->sortByDesc('id'); ?>
                    @foreach ($sortedBookmarks as $bookmark)
                        <div class="bookmark-result">
                            <label class="bookmark-checkbox">
                                <input type="checkbox" class="checkbox" value="{{ $bookmark->id }}">
                                <span class="bookmark-verse"><strong>{{ $bookmark->verse }}</strong></span>
                                <span class="bookmark-text">{{ $bookmark->verse_text }}</span>
                            </label>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<script>


// ... (previous JavaScript code) ...

document.getElementById('delete-single').addEventListener('click', deleteSelectedBookmarks);

function deleteSelectedBookmarks() {
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
            fetch(`/bookmarks/delete/${selectedIds}`, {
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


// ... (remaining JavaScript code) ...




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
            document.getElementById('bookmarkResult_' + id).remove();
        })
        .then(() => {
            window.location.reload();
        })
        .catch(error => {
            console.error('Error deleting bookmark:', error);
        });
    }
}

    
function deleteAllBookmarks() {
    Swal.fire({
        title: 'Delete All Saved Bookmarks?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
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
                Swal.fire(
                    'Deleted!',
                    'All bookmarks have been deleted.',
                    'success'
                );
            })
            .catch(error => {
                console.error('Error deleting bookmarks:', error);
            });
        }
    });
}






// function redirectToBible(selectedBookmark) {
//     var valueofClick = self.value;
//     console.log('valueofClick: 'valueofClick);
// //   window.location.href = `/bible?search=${encodeURIComponent(selectedBookmark)}`;
// }

function handleBookmarkResultClick(event) {
  var bookmarkContent = event.currentTarget.querySelector('strong').textContent;
  var parts = bookmarkContent.split('.');
  var extractedChapter = parts.slice(0, 2).join('.');
  window.location.href = `/bible?chapter=${encodeURIComponent(bookmarkContent)}`;
}

// Get all the bookmark result elements
var bookmarkResults = document.querySelectorAll('.bookmark-result');


// Add click event listener to each bookmark result element
bookmarkResults.forEach(result => {
  result.addEventListener('dblclick', handleBookmarkResultClick);
});

//tooltip
bookmarkResults.setAttribute('title', 'Double-click to read the verse')

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
