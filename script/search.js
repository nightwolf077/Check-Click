var blurTimeout;

function handleBlur() {
  clearTimeout(blurTimeout);

  blurTimeout = setTimeout(function () {
    dropdownResults.style.display = "none";
  }, 500);
}

function handleFocus() {
  var searchTerm = document.getElementById("search");

  if (searchTerm.value.length >= 1) {
    dropdownResults.style.display = "block";
  }
}

function handleSearchChange() {
  var searchTerm = document.getElementById("search").value;
  // getting the input 
  if (searchTerm.length === 0) {
    document.getElementById("dropdownResults").style.display = "none";
  } else {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "PHP/search.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        // Parse the JSON response into a JavaScript array
        var products = JSON.parse(xhr.responseText);

        // search for it 
        // Display the dropdown results
        displayDropdownResults(products);
      }
    };

    xhr.send("search=" + searchTerm);
  }
}

function displayDropdownResults(products) {
  var dropdownResults = document.getElementById("dropdownResults");
  let noResult;
  dropdownResults.innerHTML = "";
  if (products.length === 0) {
    noResult = true;
    var noResultsItem = document.createElement("a");
    noResultsItem.classList.add("no-results");
    noResultsItem.textContent = "No results found";
    dropdownResults.appendChild(noResultsItem);
  } else {
    noResult = false;
    // Display results in the dropdown
    products.forEach(function (product) {
      var resultItem = document.createElement("a");

      var itemDetails = document.createElement("div");
      itemDetails.classList.add("item-details");

      var img = document.createElement("img");
      img.src = product.image;
      img.alt = product.name;

      var textDetails = document.createElement("div");

      var itemName = document.createElement("span");
      itemName.textContent = product.name;

      textDetails.appendChild(itemName);

      itemDetails.appendChild(img);
      itemDetails.appendChild(textDetails);

      resultItem.appendChild(itemDetails);

      resultItem.addEventListener("click", function () {
        dropdownResults.style.display = "none";
        window.location.href = "spro.php?id=" + product.id;
      });

      dropdownResults.appendChild(resultItem);
    });
  }

  dropdownResults.style.display =
    products.length > 0 || noResult ? "block" : "none";
}
