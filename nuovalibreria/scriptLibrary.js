var contatoreScaffali = 2;

function addLibrary(libraryImg) {
  document.getElementsByClassName("form")[0].appendChild(library(libraryImg));
  document.getElementById("counter").innerHTML = contatoreScaffali;
  contatoreScaffali++;
}
function library(libraryImg) {
  var y = document.createElement("IMG");
  y.setAttribute("src", libraryImg);
  y.setAttribute("width", "300");
  y.setAttribute("alt", "scaffale");
  y.setAttribute("class","scaffale");
  return y;
}
