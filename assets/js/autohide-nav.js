var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
  var currentScrollPos = window.pageYOffset;
  if (180 > currentScrollPos) {
    document.getElementById("autohide").style.top = "0";
  } else {
    document.getElementById("autohide").style.top = "-200px";
  }
  prevScrollpos = currentScrollPos;
}