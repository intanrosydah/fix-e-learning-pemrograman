window.addEventListener("scroll", function () {
  var header = document.getElementById("main-header");
  if (window.scrollY > 50) {
    header.style.backgroundColor = "rgba(0, 0, 0, 0.8)"; // Sticky transparent effect
  } else {
    header.style.backgroundColor = "transparent";
  }
});
