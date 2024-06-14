function showRatingInfo(element) {
  var ratingInfoDiv = document.createElement("div");
  ratingInfoDiv.className = "rating-info";

  fetch("PHP/getRatingInfo.php")
    .then((response) => response.json())
    .then((data) => {
      displayRatingInfo(data);
    })
    .catch((error) =>
      console.error("Error fetching item rating information:", error)
    );

  ratingInfoDiv.textContent = "Loading...";

  element.appendChild(ratingInfoDiv);
  ratingInfoDiv.style.display = "block";
}

function hideRatingInfo(element) {
  var ratingInfoDiv = element.querySelector(".rating-info");
  if (ratingInfoDiv) {
    ratingInfoDiv.parentNode.removeChild(ratingInfoDiv);
  }
}

function displayRatingInfo(data) {
  var ratingInfoDiv = document.querySelector(".rating-info");

  if (ratingInfoDiv) {
    if (ratingInfoDiv.innerHTML) {
      ratingInfoDiv.innerHTML = "";
    }

    data.forEach((itemRating) => {
      var ratingItem = document.createElement("div");
      ratingItem.textContent = `${itemRating.percentage}% rated ${itemRating.item_rate} Stars`;
      ratingInfoDiv.appendChild(ratingItem);
    });
  }
}
