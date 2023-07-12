@extends('layouts.app')

@section('content')

<head>
  <style>
    body {
      height: 0%;
      width: 100%;
      margin: 0 !important;
      padding: 0 !important;
    }
    
    .bible-search-card{
      height: 25%;
      width: 32%;
    background-color: white;
    border-radius: 10px;
    }
    .bible-search-body{
    height: 100px;
    padding: 20px;
    }
    .search-container {
    display: flex;
    justify-content: flex-end;
    margin-right: 19%;
}
  </style>
</head>


<div class="bible__container">
  <h1>Bible Page</h1>
  <div class="select-container">
    <select id="bookSelect" onchange="loadChapters()">
      <option value="">Select Book</option>
    </select>
    <select id="chapterSelect" onchange="loadVerses()">
      <option value="">Select Chapter</option>
    </select>
  </div>
  
  <form id="searchForm" class="search-container">
    @csrf
    <div class="bible-search-card">
            <div class="bible-search-body col d-flex align-items-center">
                    <div class="input-group">
                    <input type="text" name="query" id="searchInput" class="search-container-input" placeholder="Enter a word">
                    </div>
                    <div class="search__button">
                      <button type="submit" class="search-container-btn">Search</button>
                    </div>
            </div>
        </div>
  </form>

  <div class="output__container">
    <div class="output-container">
      <h2 id="chapterHeading" class="chapter__heading"></h2>
      <div id="versesList" class="verseOutput"></div>
    </div>
  </div>

  <script>
    document.getElementById('searchForm').addEventListener('submit', function(event) {
      event.preventDefault(); // Prevent the default form submission

      // Get the search query
      var searchQuery = document.getElementById('searchInput').value;

      // Call the searchBible() function
searchBible(searchQuery);
    });

    // Function to perform the Bible search
    function searchBible() {
  var searchWords = document.getElementById('searchInput').value.toLowerCase().split(' ');
  var versesList = document.getElementById('versesList');
  var chapterHeading = document.getElementById('chapterHeading');

  versesList.innerHTML = '';

  if (searchWords.length === 0) {
    return;
  }

  var apiKey = 'fefe1d231e882b1423255e91e6d1cddf'; // Replace with your actual API key
  var bibleVersion = 'de4e12af7f28f599-01'; // Replace with the appropriate Bible version ID

  fetch(`https://api.scripture.api.bible/v1/bibles/${bibleVersion}/search?query=${searchWords.join(' ')}`, {
    headers: {
      'api-key': apiKey
    }
  })
    .then(response => response.json())
    .then(data => {
      var verses = data.data.verses;
      
      // Sort verses based on the number of occurrences of the searched word
      verses.sort((a, b) => {
        var occurrencesA = countOccurrences(a.text.toLowerCase(), searchWords);
        var occurrencesB = countOccurrences(b.text.toLowerCase(), searchWords);
        return occurrencesB - occurrencesA;
      });

      if (verses.length === 0) {
        var noMatchMessage = document.createElement('span');
        noMatchMessage.textContent = 'No matching verses found.';
        versesList.appendChild(noMatchMessage);
      } else {
        verses.forEach(function (verse) {
          var verseItem = document.createElement('li');
          verseItem.classList.add('verse-item');
          verseItem.style.marginBottom = '10px';
          var verseText = verse.text;
          var highlightedText = highlightSearchQuery(verseText, searchWords);
          var bookmarkBtn = document.createElement('button');
          bookmarkBtn.classList.add('bookmark-btn');
          bookmarkBtn.innerHTML = "<i class='fas fa-bookmark'></i>";
          bookmarkBtn.addEventListener('click', function () {
            handleBookmark(verse.reference, verseText);
          });
          verseItem.innerHTML = verse.reference + ' - ' + highlightedText;
          verseItem.appendChild(bookmarkBtn);

          var shareIcons = document.createElement('div');
          shareIcons.classList.add('share-icons');
          var twitterLink = createTwitterShareLink(verse.reference, verseText);
          var facebookLink = createFacebookShareLink(verse.reference, verseText);
          shareIcons.innerHTML = twitterLink + facebookLink;
          verseItem.appendChild(shareIcons);

          versesList.appendChild(verseItem);
        });
        chapterHeading.textContent = "Search results for: " + '"' + searchWords + '"';
      }

      // Send search query to server
      var searchQuery = searchWords.join(' ');
      sendSearchQuery(searchQuery);
    })
    .catch(error => {
      console.error('Error fetching Bible verses:', error);
    });
}

// Function to count the occurrences of a word in a text
function countOccurrences(text, searchWords) {
  var count = 0;
  searchWords.forEach(word => {
    var regex = new RegExp('\\b' + word + '\\b', 'gi');
    var matches = text.match(regex);
    count += matches ? matches.length : 0;
  });
  return count;
}



function sendSearchQuery(searchQuery) {
  fetch('{{ route('search') }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    body: JSON.stringify({ query: searchQuery })
  })
    .then(response => response.json())
    .then(data => {
      // Handle the search results
      console.log(data.message);
    })
    .catch(error => {
      console.error('Error performing search:', error);
    });
}


    // Function to highlight the search query in the verse text
    function highlightSearchQuery(text, searchWords) {
      var regex = new RegExp(searchWords.join('|'), 'gi');
      return text.replace(regex, function(match) {
        return "<span class='highlight'>" + match + '</span>';
      });
    }

    // Function to handle bookmarking a verse
    function handleBookmark(reference, text) {
      // Implement the logic to handle bookmarking a verse
    }

    function createTwitterShareLink(reference, text) {
      var twitterText = reference + ' - ' + text + ' Verse Guru';
      var twitterUrl = 'https://twitter.com/intent/tweet?text=' + encodeURIComponent(twitterText);
      var twitterLink = "<a href='" + twitterUrl + "' target='_blank'><i class='fab fa-twitter'></i></a>";
      return twitterLink;
    }

    // Function to create a Facebook share link
    function createFacebookShareLink(reference, text) {
      var facebookUrl = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href);
      var facebookLink = "<a href='" + facebookUrl + "' target='_blank'><i class='fab fa-facebook'></i></a>";
      return facebookLink;
    }

    function loadBooks() {
      var apiKey = 'fefe1d231e882b1423255e91e6d1cddf';
      var apiUrl = 'https://api.scripture.api.bible/v1/bibles/de4e12af7f28f599-01/books';
      var bookSelect = document.getElementById('bookSelect');

      fetch(apiUrl, {
        headers: {
          'api-key': apiKey
        }
      })
        .then(response => response.json())
        .then(data => {
          var books = data.data;
          books.forEach(function(book) {
            var option = document.createElement('option');
            option.value = book.id;
            option.textContent = book.name;
            bookSelect.appendChild(option);
          });
        })
        .catch(error => {
          console.error('Error fetching Bible books:', error);
        });
    }

    function loadChapters() {
      var bookId = document.getElementById('bookSelect').value;
      var apiKey = 'fefe1d231e882b1423255e91e6d1cddf';
      var apiUrl = `https://api.scripture.api.bible/v1/bibles/de4e12af7f28f599-01/books/${bookId}/chapters`;
      var chapterSelect = document.getElementById('chapterSelect');

      chapterSelect.innerHTML = '<option value="">Select Chapter</option>';

      fetch(apiUrl, {
        headers: {
          'api-key': apiKey
        }
      })
        .then(response => response.json())
        .then(data => {
          var chapters = data.data;
          chapters.forEach(function(chapter) {
            var option = document.createElement('option');
            option.value = chapter.id;
            option.textContent = chapter.reference;
            chapterSelect.appendChild(option);
          });
        })
        .catch(error => {
          console.error('Error fetching Bible chapters:', error);
        });
    }

    function loadVerses() {
      var bookId = document.getElementById('bookSelect').value;
      var chapterId = document.getElementById('chapterSelect').value;
      var versesList = document.getElementById('versesList');
      var chapterHeading = document.getElementById('chapterHeading');

      versesList.innerHTML = '';

      if (chapterId !== '') {
        var apiKey = 'fefe1d231e882b1423255e91e6d1cddf';
        var apiUrl = `https://api.scripture.api.bible/v1/bibles/de4e12af7f28f599-01/chapters/${chapterId}/verses`;

        fetch(apiUrl, {
          headers: {
            'api-key': apiKey
          }
        })
          .then(response => response.json())
          .then(data => {
            var verseIds = data.data.map(verse => verse.id);
            var versePromises = verseIds.map(verseId => {
              var verseApiUrl = `https://api.scripture.api.bible/v1/bibles/de4e12af7f28f599-01/verses/${verseId}`;
              return fetch(verseApiUrl, {
                headers: {
                  'api-key': apiKey
                }
              }).then(response => response.json());
            });

            Promise.all(versePromises)
              .then(verses => {
                verses.sort((a, b) => {
                  var refA = parseInt(a.data.reference.split(' ')[1]);
                  var refB = parseInt(b.data.reference.split(' ')[1]);
                  return refA - refB;
                });

                verses.forEach(verse => {
                  var verseItem = document.createElement('span');
                  const reference = verse.data.reference;
                  const content = verse.data.content.replace(/<\/?p[^>]*>|<\/?span[^>]*>/g, '');
                  const verseNumber = reference.match(/\d+$/)[0];
                  verseItem.textContent = content;
                  verseItem.dataset.reference = reference;


                  versesList.appendChild(verseItem);
                });

                // Display header of chapter
                chapterHeading.textContent = chapterSelect.options[chapterSelect.selectedIndex].textContent;
              })
              .catch(error => {
                console.error('Error fetching Bible verses:', error);
              });
          })
          .catch(error => {
              console.error('Error fetching Bible chapters:', error);
          });
      }
    }

    // Load books on page load
    loadBooks();

    // Add event listener to handle verse hover
    var verseOutput = document.getElementById('versesList');
    verseOutput.addEventListener('mouseover', function(event) {
      var verseItem = event.target;
      if (verseItem.tagName === 'SPAN') {
        verseItem.style.fontWeight = 'bold';
      }
    });

    verseOutput.addEventListener('mouseout', function(event) {
      var verseItem = event.target;
      if (verseItem.tagName === 'SPAN') {
        verseItem.style.fontWeight = 'normal';
      }
    });

    function createShareWindow(reference, text) {
      var twitterText = reference + ' - ' + text + ' - Retrieved from Verse Guru';
      var twitterUrl = 'https://twitter.com/intent/tweet?text=' + encodeURIComponent(twitterText);
      var facebookUrl = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href);

      var popupWidth = 600;
      var popupHeight = 400;
      var leftPosition = (window.innerWidth - popupWidth) / 2;
      var topPosition = (window.innerHeight - popupHeight) / 2;

      window.open(twitterUrl, 'Share on Twitter', 'width=' + popupWidth + ', height=' + popupHeight + ', left=' + leftPosition + ', top=' + topPosition);
      window.open(facebookUrl, 'Share on Facebook', 'width=' + popupWidth + ', height=' + popupHeight + ', left=' + leftPosition + ', top=' + topPosition);
    }

    verseOutput.addEventListener('click', function(event) {
      var verseItem = event.target;
      if (verseItem.tagName === 'SPAN') {
        var verseText = verseItem.textContent;
        var verseReference = verseItem.dataset.reference;
        createShareWindow(verseReference, verseText);
      }
    });
  </script>
@endsection
