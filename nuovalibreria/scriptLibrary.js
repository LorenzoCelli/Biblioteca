
function addLibrary(libraryImg, div) {
  document.getElementsByClassName("libreria")[0].appendChild(library(libraryImg));
}
function library(libraryImg) {
  var y = document.createElement("IMG");
  y.setAttribute("src", libraryImg);
  y.setAttribute("width", "390");
  y.setAttribute("alt", "scaffale");
  y.setAttribute("class","scaffale");
  return y;
}
