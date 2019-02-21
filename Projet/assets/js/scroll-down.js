$(document).ready(function () {
  $("a").on('click', function (event) {
    if (this.hash !== "") {
      event.preventDefault();
      var hash = this.hash;
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 800, function () {
        window.location.hash = hash;
      });
    }
  });
});

$(window).on("scroll", function() {
  if($(window).scrollTop()) {
    document.getElementById("test").style.backgroundColor = "rgb(255, 255, 255)";
  }
  else {
    document.getElementById("test").style.backgroundColor = "rgb(255, 255, 255, 0)";
  }
})
