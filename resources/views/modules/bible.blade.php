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
    .verseOutput .verse-item span:hover {
      font-weight: bold;
    }
    
    .share-icons {
      display: none;
    }
    
    .verse-item:hover .share-icons {
      display: block;
    }
    
    .share-icons a {
      display: inline-block;
      margin-right: 5px;
      color: #555;
      text-decoration: none;
    }
    
    .highlight {
      font-weight: bold;
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
  <div class="search-container">
    <input type="text" id="searchInput" class="search-container-input" placeholder="Enter a word">
    <input class="search-container-btn" type="submit" value="Search" onclick="searchBible()">
  </div>
  <div class="output__container">
    <div class="output-container">
      <h2 id="chapterHeading" class="chapter__heading"></h2>
      <div id="versesList" class="verseOutput"></div>
    </div>
  </div>

  <script>
    function loadBooks() {
      var apiKey = "fefe1d231e882b1423255e91e6d1cddf";
      var apiUrl = "https://api.scripture.api.bible/v1/bibles/de4e12af7f28f599-01/books";
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
      var apiUrl = `https://api.scripture.api.bible/v1/bibles/de4e12af7f28f599-01/books/${bookId}/chapters`;
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

      versesList.innerHTML = "";

      if (chapterId !== "") {
        var apiKey = "fefe1d231e882b1423255e91e6d1cddf";
        var apiUrl = `https://api.scripture.api.bible/v1/bibles/de4e12af7f28f599-01/chapters/${chapterId}/verses`;

        fetch(apiUrl, {
            headers: {
              "api-key": apiKey
            }
          })
          .then(response => response.json())
          .then(data => {
            var verseIds = data.data.map(verse => verse.id);
            var versePromises = verseIds.map(verseId => {
              var verseApiUrl = `https://api.scripture.api.bible/v1/bibles/de4e12af7f28f599-01/verses/${verseId}`;
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
                  verseItem.dataset.reference = reference;


                  versesList.appendChild(verseItem);
                });
 
// Display header of chapter 
              chapterHeading.textContent = chapterSelect.options[chapterSelect.selectedIndex].textContent;

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

    function searchBible() {
  var searchWords = document.getElementById("searchInput").value.toLowerCase().split(" ");
  var versesList = document.getElementById("versesList");
  versesList.innerHTML = "";

  if (searchWords.length === 0) {
    return;
  }

  var apiKey = "fefe1d231e882b1423255e91e6d1cddf"; // Replace with your actual API key
  var bibleVersion = "de4e12af7f28f599-01"; // Replace with the appropriate Bible version ID

  fetch(`https://api.scripture.api.bible/v1/bibles/${bibleVersion}/search?query=${searchWords.join(" ")}`, {
    headers: {
      "api-key": apiKey
    }
  })
    .then(response => response.json())
    .then(data => {
      var verses = data.data.verses;
      if (verses.length === 0) {
        var noMatchMessage = document.createElement("span");
        noMatchMessage.textContent = "No matching verses found.";
        versesList.appendChild(noMatchMessage);
      } else {
        verses.forEach(function (verse) {
          var verseItem = document.createElement("li");
          verseItem.classList.add("verse-item");
          verseItem.style.marginBottom = "10px";
          var verseText = verse.text;
          varhighlightedText = highlightSearchQuery(verseText, searchWords);
          var bookmarkBtn = document.createElement("button");
          bookmarkBtn.classList.add("bookmark-btn");
          bookmarkBtn.innerHTML = "<i class='fas fa-bookmark'></i>";
          bookmarkBtn.addEventListener("click", function () {
            handleBookmark(verse.reference, verseText);
          });
          verseItem.innerHTML = verse.reference + " - " + highlightedText;
          verseItem.appendChild(bookmarkBtn);

          var shareIcons = document.createElement("div");
          shareIcons.classList.add("share-icons");
          var twitterLink = createTwitterShareLink(verse.reference, verseText);
          var facebookLink = createFacebookShareLink(verse.reference, verseText);
          shareIcons.innerHTML = twitterLink + facebookLink;
          verseItem.appendChild(shareIcons);

          versesList.appendChild(verseItem);
        });
      }
    })
    .catch(error => {
      console.error("Error fetching Bible verses:", error);
    });
}
async function searchBible() {
  var searchWords = document.getElementById("searchInput").value.toLowerCase().split(" ");
  var versesList = document.getElementById("versesList");
  versesList.innerHTML = "";

  if (searchWords.length === 0) {
    return;
  }

  var apiKey = "9b24277b494bee48f28523da7b96a025"; // Replace with your actual API key
  var bibleVersion = "de4e12af7f28f599-01"; // ASV (American Standard Version)

  try {
    const response = await fetch(`https://api.scripture.api.bible/v1/bibles/${bibleVersion}/search?query=${searchWords.join(" ")}`, {
      headers: {
        "api-key": apiKey
      }
    });
    const data = await response.json();

    var verses = data.data.verses;
    if (verses.length === 0) {
      var noMatchMessage = document.createElement("li");
      noMatchMessage.textContent = "No matching verses found.";
      versesList.appendChild(noMatchMessage);
    } else {
      verses.forEach(function(verse) {
        var verseItem = document.createElement("li");
        verseItem.classList.add("verse-item");
        verseItem.style.marginBottom = "10px";
        var verseText = verse.text;
        var highlightedText = highlightSearchQuery(verseText, searchWords);
        var bookmarkBtn = document.createElement("button");
        bookmarkBtn.classList.add("bookmark-btn");
        bookmarkBtn.innerHTML = "<i class='fas fa-bookmark'></i>";
        bookmarkBtn.addEventListener("click", function() {
          handleBookmark(verse.reference, verseText);
        });
        verseItem.innerHTML = verse.reference + " - " + highlightedText;
        verseItem.appendChild(bookmarkBtn);

        var shareIcons = document.createElement("div");
        shareIcons.classList.add("share-icons");
        var twitterLink = createTwitterShareLink(verse.reference, verseText);
        var facebookLink = createFacebookShareLink(verse.reference, verseText);
        shareIcons.innerHTML = twitterLink + facebookLink;
        verseItem.appendChild(shareIcons);
        
        versesList.appendChild(verseItem);
      });
    }
  } catch (error) {
    console.error("Error fetching Bible verses:", error);
  }
}

function highlightSearchQuery(text, searchWords) {
  var regex = new RegExp(searchWords.join("|"), "gi");
  return text.replace(regex, function (match) {
    return "<span class='highlight'>" + match + "</span>";
  });
}

function handleBookmark(reference, text) {
  var bookmarkList = document.getElementById("bookmarkList");
  var bookmarkItem = document.createElement("li");
  bookmarkItem.textContent = reference + " - " + text;
  bookmarkList.appendChild(bookmarkItem);
}

function createTwitterShareLink(reference, text) {
  var twitterText = reference + " - " + text + " Verse Guru";
  var twitterUrl = "https://twitter.com/intent/tweet?text=" + encodeURIComponent(twitterText);
  var twitterLink = "<a href='" + twitterUrl + "' target='_blank'><i class='fab fa-twitter'></i></a>";
  return twitterLink;
}

function createFacebookShareLink(reference, text) {
  var facebookUrl = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(window.location.href);
  var facebookLink = "<a href='" + facebookUrl + "' target='_blank'><i class='fab fa-facebook'></i></a>";
  return facebookLink;
}
function highlightSearchKeyword(text, searchWord) {
  var regex = new RegExp(searchWord, "gi");
  return text.replace(regex, function (match) {
    return "<span class='highlight'>" + match + "</span>";
  });
}


// Load books on page load
loadBooks();


// Add event listener to handle verse hover
var verseOutput = document.getElementById("versesList");
verseOutput.addEventListener("mouseover", function(event) {
  var verseItem = event.target;
  if (verseItem.tagName === "SPAN") {
    verseItem.style.fontWeight = "bold";
  }
});

verseOutput.addEventListener("mouseout", function(event) {
  var verseItem = event.target;
  if (verseItem.tagName === "SPAN") {
    verseItem.style.fontWeight = "normal";
  }
});

function createShareWindow(reference, text) {
  var twitterText = reference + " - " + text + " - Retrieved from Verse Guru";
  var twitterUrl = "https://twitter.com/intent/tweet?text=" + encodeURIComponent(twitterText);
  var facebookUrl = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(window.location.href);

  var popupWidth = 600;
  var popupHeight = 400;
  var leftPosition = (window.innerWidth - popupWidth) / 2;
  var topPosition = (window.innerHeight - popupHeight) / 2;

  window.open(twitterUrl, "Share on Twitter", "width=" + popupWidth + ", height=" + popupHeight + ", left=" + leftPosition + ", top=" + topPosition);
  window.open(facebookUrl, "Share on Facebook", "width=" + popupWidth + ", height=" + popupHeight + ", left=" + leftPosition + ", top=" + topPosition);
}

verseOutput.addEventListener("click", function(event) {
  var verseItem = event.target;
  if (verseItem.tagName === "SPAN") {
    var verseText = verseItem.textContent;
    var verseReference = verseItem.dataset.reference;
    createShareWindow(verseReference, verseText);
  }
});
</script>
@endsection
