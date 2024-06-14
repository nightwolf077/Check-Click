function highlightStars(starNum) {
  for (var i = 1; i <= starNum; i++) {
    var starId = "star" + i;
    document.getElementById(starId).classList.add("checked");
  }
}

function resetStars() {
  var stars = document.querySelectorAll(".stars .fa");
  stars.forEach(function (star) {
    star.classList.remove("checked");
  });
}
