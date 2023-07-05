@extends('layouts.app')

@section('content')

<head>
  <style>
    body{
      height: 0%;
    width: 100%;
    margin: 0 !important;
      padding: 0 !important;
    }
   
  </style>
</head>
    <div class="bible__container">
            <h1>Bible Page</h1>
        <div class="search-container">
            <select id="bookSelect" onchange="loadChapters()">
                <option value="">Select Book</option>
            </select>
            <select id="chapterSelect" onchange="loadVerses()">
                <option value="">Select Chapter</option>
            </select>
        </div>
        <div class="output__container">
          <div class="output-container">
              <h1 id="chapterHeading"></h1>
              <span id="versesList" class="verseOutput"></span>
          </div>
        </div>
    </div>

<script>
  function loadBooks() {
    var apiKey = "fefe1d231e882b1423255e91e6d1cddf";
    var apiUrl = "https://api.scripture.api.bible/v1/bibles/685d1470fe4d5c3b-01/books";
    var bookSelect = document.getElementById("bookSelect");

    fetch(apiUrl, {
      headers: {
        "api-key": apiKey
      }
    })
      .then(response => response.json())
      .then(data => {
        var books = data.data;
        books.forEach(function(book) {
          var option = document.createElement("option");
          option.value = book.id;
          option.textContent = book.name;
          bookSelect.appendChild(option);
        });
      })
      .catch(error => {
        console.error("Error fetching Bible books:", error);
      });
  }

  function loadChapters() {
    var bookId = document.getElementById("bookSelect").value;
    var apiKey = "fefe1d231e882b1423255e91e6d1cddf";
    var apiUrl = `https://api.scripture.api.bible/v1/bibles/685d1470fe4d5c3b-01/books/${bookId}/chapters`;
    var chapterSelect = document.getElementById("chapterSelect");

    chapterSelect.innerHTML = "<option value=''>Select Chapter</option>";

    fetch(apiUrl, {
      headers: {
        "api-key": apiKey
      }
    })
      .then(response => response.json())
      .then(data => {
        var chapters = data.data;
        chapters.forEach(function(chapter) {
          var option = document.createElement("option");
          option.value = chapter.id;
          option.textContent = chapter.reference;
          chapterSelect.appendChild(option);
        });
      })
      .catch(error => {
        console.error("Error fetching Bible chapters:", error);
      });
  }

  function loadVerses() {
  var bookId = document.getElementById("bookSelect").value;
  var chapterId = document.getElementById("chapterSelect").value;
  var versesList = document.getElementById("versesList");
  var chapterHeading = document.getElementById("chapterHeading");
  var chapterHeading = document.getElementById("chapterSelect").value;

  versesList.innerHTML = "";

  if (chapterId !== "") {
    var apiKey = "fefe1d231e882b1423255e91e6d1cddf";
    var apiUrl = `https://api.scripture.api.bible/v1/bibles/685d1470fe4d5c3b-01/chapters/${chapterId}/verses`;

    fetch(apiUrl, {
      headers: {
        "api-key": apiKey
      }
    })
      .then(response => response.json())
      .then(data => {
        var verseIds = data.data.map(verse => verse.id);
        var versePromises = verseIds.map(verseId => {
          var verseApiUrl = `https://api.scripture.api.bible/v1/bibles/685d1470fe4d5c3b-01/verses/${verseId}`;
          return fetch(verseApiUrl, {
            headers: {
              "api-key": apiKey
            }
          }).then(response => response.json());
        });

        Promise.all(versePromises)
          .then(verses => {
            verses.sort((a, b) => {
              var refA = parseInt(a.data.reference.split(" ")[1]);
              var refB = parseInt(b.data.reference.split(" ")[1]);
              return refA - refB;
            });

            verses.forEach(verse => {
              var verseItem = document.createElement("span");
              const reference = verse.data.reference;
              const content = verse.data.content.replace(/<\/?p[^>]*>|<\/?span[^>]*>/g, "");
              const verseNumber = reference.match(/\d+$/)[0];
              verseItem.textContent = content;

              versesList.appendChild(verseItem);
            });

            // Update the chapter heading
            chapterHeading.textContent = "Chapter " + chapterHeading;
          })
          .catch(error => {
            console.error("Error fetching Bible verses:", error);
          });
      })
      .catch(error => {
        console.error("Error fetching Bible chapters:", error);
      });
  }
}


  // Load books on page load
  loadBooks();
</script>
@endsection
