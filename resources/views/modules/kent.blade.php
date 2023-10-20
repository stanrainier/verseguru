<!DOCTYPE html>
<html>
<head>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <title>Bible Search</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
    }
    
    h1 {
      text-align: center;
    }
    
    .search-container {
      text-align: center;
      margin-bottom: 20px;
    }
    
    .search-container input[type="text"] {
      padding: 10px;
      width: 300px;
      font-size: 16px;
    }
    
    .search-container input[type="submit"] {
      padding: 10px 20px;
      font-size: 16px;
      background-color: #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
    }
    
    .output-container {
      border: 1px solid #ccc;
      padding: 10px;
      min-height: 200px;
      margin: 0 auto;
      text-align: left;
    }
    
    .highlight {
      font-weight: bold;
    }
    
    #versesList {
      list-style-type: none;
      padding: 0;
    }
    
    .verse-item {
      position: relative;
      margin-bottom: 10px;
    }

    .bookmark-btn {
      position: absolute;
      top: 0;
      right: 0;
      background-color: transparent;
      border: none;
      color: #555;
      padding: 4px 8px;
      cursor: pointer;
    }

    #bookmarkList {
      list-style-type: none;
      padding: 0;
    }

    .bookmark-delete-icon {
      color: #f00;
      cursor: pointer;
      margin-left: 5px;
    }

    .clear-all-btn {
      float: right;
      background-color: #f00;
      border: none;
      color: #fff;
      padding: 4px 8px;
      cursor: pointer;
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

    .bookmark-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }

    .bookmark-search-container {
      margin-right: 10px;
    }

    .bookmark-search-container input[type="text"] {
      padding: 10px;
      width: 200px;
      font-size: 16px;
    }

    .bookmark-item {
      position: relative;
      margin-bottom: 10px;
      text-align: left; /* Add this line to align the verses on the left */
    }

    .bookmark-category {
      display: inline-block;
      width: 120px;
      text-align: left;
      font-weight: bold;
      margin-right: 10px;
    }

    .bookmark-text {
      display: inline-block;
    }

    .bookmark-checkbox {
      display: inline-block;
      margin-right: 5px;
    }

    .bookmark-delete-btn {
      background-color: transparent;
      border: none;
      color: #f00;
      padding: 0;
      cursor: pointer;
      margin-left: 5px;
    }

    .bookmark-category-dropdown {
      margin-right: 5px;
    }

    /* Modal styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 10% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 300px;
    }

    .modal-close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }

    .modal-close:hover,
    .modal-close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    .category-list {
      width: 200px; /* Adjust the width as needed */
    }

    .category-list option {
      /* Optional: Apply additional styling to the dropdown options if desired */
    }
    </style>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <meta property="og:title" content="Bible Verse" />
  <meta property="og:description" content="" />
  <meta property="og:url" content="" />
</head>
<body>
  <h1>Bible Search</h1>
  <div class="search-container">
    <input type="text" id="searchInput" placeholder="Enter a word">
    <button onclick="startSpeechToText()"><i class="fas fa-microphone"></i></button>
    <input type="submit" value="Search" onclick="searchBible()">
  </div>
  <div class="output-container">
    <ul id="versesList"></ul>
  </div>

  <h2>Bookmarks</h2>
  <div class="bookmark-header">
    <div class="bookmark-search-container">
      <input type="text" id="bookmarkSearchInput" placeholder="Search Bookmarks" onkeyup="searchBookmarks()">
    </div>
    <div class="category-dropdown">
      <select id="categoryFilter" onchange="filterBookmarksByCategory()">
        <option value="">All Categories</option>
        <option value="The Law">The Law</option>
        <option value="History">History</option>
        <option value="Wisdom">Wisdom</option>
        <option value="Prophets">Prophets</option>
        <option value="The Gospels">The Gospels</option>
        <option value="Church History">Church History</option>
        <option value="Paul's Letters">Paul's Letters</option>
        <option value="General Letters">General Letters</option>
        <option value="Prophecy">Prophecy</option>
      </select>
    </div>
    <button class="clear-all-btn" onclick="clearAllBookmarks()">Clear All</button>
  </div>
  <div class="output-container">
    <ul id="bookmarkList"></ul>
  </div>
  
  <h2>Cross-Reference</h2>
  <div class="output-container">
    <ul id="crossReferenceList"></ul>
  </div>
  
  <!-- Modal form -->
  <div id="modalForm" class="modal">
    <div class="modal-content">
      <span id="modalClose" class="modal-close">&times;</span>
      <h2>Select Category</h2>
      <select id="categoryList" class="category-list">
        <option value="">Select a category</option>
      </select>
      <button onclick="assignCategory()">Assign Category</button>
    </div>
  </div>

  <script>
    var bookmarkedVerses = [];
var categories = [
  "The Law",
  "History",
  "Wisdom",
  "Prophets",
  "The Gospels",
  "Church History",
  "Paul's Letters",
  "General Letters",
  "Prophecy"
];

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

        var speechBtn = document.createElement("button");
        speechBtn.classList.add("text-to-speech-btn");
        speechBtn.innerHTML = "<i class='fas fa-volume-up'></i>";
        speechBtn.addEventListener("click", function() {
          speakVerse(verseText);
        });
        verseItem.appendChild(speechBtn);

        var shareIcons = document.createElement("div");
        shareIcons.classList.add("share-icons");
        var twitterLink = createTwitterShareLink(verse.reference, verseText);
        var redditLink = createRedditShareLink(verse.reference, verseText); // Added Reddit share link
        shareIcons.innerHTML = twitterLink + redditLink; // Replaced Facebook link with Reddit link
        verseItem.appendChild(shareIcons);
        
        verseItem.addEventListener("click", function() {
          showCrossReferences(verse.reference);
        });

        versesList.appendChild(verseItem);
      });
    }
  } catch (error) {
    console.error("Error fetching Bible verses:", error);
  }
}

function highlightSearchQuery(text, searchWords) {
  var regex = new RegExp(searchWords.join("|"), "gi");
  return text.replace(regex, function(match) {
    return "<span class='highlight'>" + match + "</span>";
  });
}

function handleBookmark(reference, text) {
  // Check if the verse is already bookmarked
  var isAlreadyBookmarked = bookmarkedVerses.some(function (verse) {
    return verse.reference === reference;
  });

  if (isAlreadyBookmarked) {
    // Verse is already bookmarked, do not add it again
    return;
  }

  var bookmarkList = document.getElementById("bookmarkList");
  bookmarkList.innerHTML = ""; // Clear existing bookmarks

  var bookmarkedVerse = { reference: reference, text: text, category: "" }; // Create bookmark object with category property
  bookmarkedVerses.push(bookmarkedVerse); // Add bookmarked verse to the array

  bookmarkedVerses.forEach(function (verse) {
    var bookmarkItem = document.createElement("li");
    bookmarkItem.classList.add("bookmark-item");

    var bookmarkCategory = document.createElement("span");
    bookmarkCategory.classList.add("bookmark-category");
    bookmarkCategory.textContent = verse.category;
    bookmarkItem.appendChild(bookmarkCategory);

    var bookmarkText = document.createElement("span");
    bookmarkText.classList.add("bookmark-text");
    bookmarkText.textContent = verse.reference + " - " + verse.text;
    bookmarkItem.appendChild(bookmarkText);

    var labelBtn = document.createElement("button");
    labelBtn.innerHTML = "<i class='fas fa-tag'></i>"; // Change to label icon
    labelBtn.classList.add("bookmark-label-btn");
    labelBtn.addEventListener("click", function () {
      handleLabel(verse.reference);
    });
    bookmarkItem.appendChild(labelBtn);

    var deleteBtn = document.createElement("button");
    deleteBtn.innerHTML = "<i class='fas fa-trash'></i>";
    deleteBtn.classList.add("bookmark-delete-btn");
    deleteBtn.addEventListener("click", function () {
      handleBookmarkDelete(verse.reference);
    });
    bookmarkItem.appendChild(deleteBtn);

    bookmarkList.appendChild(bookmarkItem);
  });
}

function handleLabel(reference) {
  var bookmarkedVerse = bookmarkedVerses.find(function (verse) {
    return verse.reference === reference;
  });

  if (bookmarkedVerse) {
    // Open the modal form
    var modal = document.getElementById("modalForm");
    modal.style.display = "block";

    // Pass the verse reference to the modal form
    var categoryList = document.getElementById("categoryList");
    categoryList.dataset.reference = reference;

    // Clear previous options
    categoryList.innerHTML = "";

    // Add options to the category dropdown
    var defaultOption = document.createElement("option");
    defaultOption.value = "";
    defaultOption.text = "Select a category";
    categoryList.appendChild(defaultOption);

    categories.forEach(function (category) {
      var option = document.createElement("option");
      option.value = category;
      option.text = category;
      categoryList.appendChild(option);
    });
  }
}

function assignCategory() {
  var categoryList = document.getElementById("categoryList");
  var selectedCategory = categoryList.options[categoryList.selectedIndex].value;

  if (selectedCategory) {
    var reference = categoryList.dataset.reference;

    var bookmarkedVerse = bookmarkedVerses.find(function (verse) {
      return verse.reference === reference;
    });

    if (bookmarkedVerse) {
      bookmarkedVerse.category = selectedCategory;
    }

    // Close the modal form
    var modal = document.getElementById("modalForm");
    modal.style.display = "none";

    // Refresh the bookmark list
    var bookmarkSearchInput = document.getElementById("bookmarkSearchInput");
    bookmarkSearchInput.value = ""; // Clear the search input
    searchBookmarks();
  }
}

function handleBookmarkDelete(reference) {
  var bookmarkedVerseIndex = bookmarkedVerses.findIndex(function (verse) {
    return verse.reference === reference;
  });

  if (bookmarkedVerseIndex !== -1) {
    bookmarkedVerses.splice(bookmarkedVerseIndex, 1);
  }

  // Refresh the bookmark list
  var bookmarkSearchInput = document.getElementById("bookmarkSearchInput");
  bookmarkSearchInput.value = ""; // Clear the search input
  searchBookmarks();
}

function searchBookmarks() {
  var bookmarkSearchInput = document.getElementById("bookmarkSearchInput");
  var categoryFilter = document.getElementById("categoryFilter").value;
  var bookmarkList = document.getElementById("bookmarkList");
  bookmarkList.innerHTML = "";

  var searchKeywords = bookmarkSearchInput.value.toLowerCase().split(" ");

  bookmarkedVerses.forEach(function (verse) {
    var reference = verse.reference.toLowerCase();
    var text = verse.text.toLowerCase();

    var containsKeywords = searchKeywords.every(function (keyword) {
      return reference.includes(keyword) || text.includes(keyword);
    });

    var matchesCategory = categoryFilter === "" || verse.category === categoryFilter;

    if (containsKeywords && matchesCategory) {
      var bookmarkItem = document.createElement("li");
      bookmarkItem.classList.add("bookmark-item");

      var bookmarkCategory = document.createElement("span");
      bookmarkCategory.classList.add("bookmark-category");
      bookmarkCategory.textContent = verse.category;
      bookmarkItem.appendChild(bookmarkCategory);

      var bookmarkText = document.createElement("span");
      bookmarkText.classList.add("bookmark-text");
      bookmarkText.textContent = verse.reference + " - " + verse.text;
      bookmarkItem.appendChild(bookmarkText);

      var labelBtn = document.createElement("button");
      labelBtn.innerHTML = "<i class='fas fa-tag'></i>"; // Change to label icon
      labelBtn.classList.add("bookmark-label-btn");
      labelBtn.addEventListener("click", function () {
        handleLabel(verse.reference);
      });
      bookmarkItem.appendChild(labelBtn);

      var deleteBtn = document.createElement("button");
      deleteBtn.innerHTML = "<i class='fas fa-trash'></i>";
      deleteBtn.classList.add("bookmark-delete-btn");
      deleteBtn.addEventListener("click", function () {
        handleBookmarkDelete(verse.reference);
      });
      bookmarkItem.appendChild(deleteBtn);

      bookmarkList.appendChild(bookmarkItem);
    }
  });
}

function filterBookmarksByCategory() {
  var categoryFilter = document.getElementById("categoryFilter").value;
  var bookmarkSearchInput = document.getElementById("bookmarkSearchInput");
  bookmarkSearchInput.value = ""; // Clear the search input
  searchBookmarks();
}

function clearAllBookmarks() {
  bookmarkedVerses = [];
  var bookmarkList = document.getElementById("bookmarkList");
  bookmarkList.innerHTML = "";
}

function createTwitterShareLink(reference, text) {
  var shareText = `Check out this Bible verse: ${reference} - "${text}"`;
  var encodedShareText = encodeURIComponent(shareText);
  var twitterShareLink = `<a href="https://twitter.com/intent/tweet?text=${encodedShareText}" target="_blank" rel="noopener" aria-label="Share on Twitter"><i class="fab fa-twitter"></i></a>`;
  return twitterShareLink;
}

function createRedditShareLink(reference, text) {
  var shareText = `Check out this Bible verse: ${reference} - "${text}"`;
  var encodedShareText = encodeURIComponent(shareText);
  var redditShareLink = `<a href="https://www.reddit.com/submit?url=${encodedShareText}&title=${encodedShareText}" target="_blank" rel="noopener" aria-label="Share on Reddit"><i class="fab fa-reddit"></i></a>`;
  return redditShareLink;
}

function showCrossReferences(reference) {
  var crossReferenceList = document.getElementById("crossReferenceList");
  crossReferenceList.innerHTML = ""; // Clear existing cross-references

  // Add cross-reference logic here...

  // Example: Display a placeholder message
  var placeholderMessage = document.createElement("li");
  placeholderMessage.textContent = "Cross-references for " + reference + " will be displayed here.";
  crossReferenceList.appendChild(placeholderMessage);
}

// Speech-to-text feature
function startSpeechToText() {
  if (window.hasOwnProperty("webkitSpeechRecognition")) {
    var recognition = new webkitSpeechRecognition();

    recognition.continuous = false;
    recognition.interimResults = false;
    recognition.lang = "en-US";
    recognition.start();

    recognition.onresult = function(event) {
      document.getElementById("searchInput").value = event.results[0][0].transcript;
      recognition.stop();
    };

    recognition.onerror = function(event) {
      console.error("Speech recognition error:", event.error);
      recognition.stop();
    };
  }
}

function speakVerse(text) {
  var msg = new SpeechSynthesisUtterance();
  msg.text = text;
  window.speechSynthesis.speak(msg);
}

// Modal functionality
var modal = document.getElementById("modalForm");
var modalClose = document.getElementById("modalClose");
modalClose.addEventListener("click", function () {
  modal.style.display = "none";
});

window.addEventListener("click", function (event) {
  if (event.target === modal) {
    modal.style.display = "none";
  }
});
async function showCrossReferences(reference) {
var crossReferenceList = document.getElementById("crossReferenceList");
crossReferenceList.innerHTML = ""; // Clear existing cross-references

var apiKey = "9b24277b494bee48f28523da7b96a025"; // Replace with your actual API key
var bibleVersion = "de4e12af7f28f599-01"; // Replace with the desired Bible version (e.g., "de4e12af7f28f599-01" for ASV)

try {
const response = await fetch(`https://api.scripture.api.bible/v1/bibles/${bibleVersion}/passages/${reference}/crossrefs`, {
  headers: {
    "api-key": apiKey
  }
});

if (!response.ok) {
  throw new Error(`API request failed with status ${response.status} - ${response.statusText}`);
}

const data = await response.json();

if (!data || !data.data || !Array.isArray(data.data)) {
  throw new Error("Invalid API response format");
}

var crossReferences = data.data;
if (crossReferences.length === 0) {
  var noCrossRefMessage = document.createElement("li");
  noCrossRefMessage.textContent = "No cross-references found for " + reference + ".";
  crossReferenceList.appendChild(noCrossRefMessage);
} else {
  crossReferences.forEach(function (crossRef) {
    var crossRefItem = document.createElement("li");
    crossRefItem.textContent = crossRef.reference;
    crossReferenceList.appendChild(crossRefItem);
  });
}
} catch (error) {
console.error("Error fetching cross-references:", error.message);
var errorCrossRefMessage = document.createElement("li");
errorCrossRefMessage.textContent = "Error fetching cross-references: " + error.message;
crossReferenceList.appendChild(errorCrossRefMessage);
}
}
  </script>

</body>
</html>
