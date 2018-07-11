var checkColor = 0;
var colorePrecedente;
function show_hide(element_id) {
    var element = document.getElementById(element_id);
    if(element.style.width === "" || element.style.width === "0px"){
        element.style.width = "500px";
    }else{
        element.style.width = "0px";
    }
}
function slide_left(element_id){
    var element = document.getElementById(element_id);
    if(!element.is_open){
        element.style.transform = "translateX(-400px)";
        element.is_open = true;
    }else{
        element.style.transform = "translateX(0)";
        element.is_open = false;
    }
}
function slide_right(element_id){
    var element = document.getElementById(element_id);
    if(!element.is_open){
        element.style.transform = "translateX(0)";
        element.is_open = true;
    }else{
        element.style.transform = "translateX(-300px)";
        element.is_open = false;
    }
}
var contatoreScaffali = 1;

function addLibrary(libraryImg) {
  document.getElementsByClassName("containerScaffali")[0].appendChild(library(libraryImg));
  contatoreScaffali++;
  document.getElementById("counter").value = contatoreScaffali;
}
function removeLibrary() {
  if (contatoreScaffali > 1) {
    document.getElementsByClassName("containerScaffali")[0].removeChild(document.getElementsByClassName("scaffale")[1]);
    contatoreScaffali--;
    document.getElementById("counter").value = contatoreScaffali;
  }
}
function addMoreLibrary(libraryImg) {
  var count = document.getElementById("counter").value;
  if (count >= 1) {
    if (count > contatoreScaffali) {
      var temp = count;
      count = count - contatoreScaffali;
      contatoreScaffali = temp;
      for (var i = 0; i < count; i++) {
        document.getElementsByClassName("containerScaffali")[0].appendChild(library(libraryImg));
      }
    }else if (count < contatoreScaffali) {
      contatoreScaffali = contatoreScaffali - count;
      for (var i = 0; i < contatoreScaffali; i++) {
        document.getElementsByClassName("containerScaffali")[0].removeChild(document.getElementsByClassName("scaffale")[1]);
      }
      contatoreScaffali = count;
    }
  }
}
function library(libraryImg) {
  var y = document.createElement("IMG");
  y.setAttribute("src", libraryImg);
  y.setAttribute("width", "300");
  y.setAttribute("alt", "scaffale");
  y.setAttribute("class","scaffale");
  y.style.margin = "-30px 0 0";
  return y;
}
function changeHeightDown() {
  document.getElementsByClassName("colorContainer")[0].style.borderBottomLeftRadius = "0px"
  document.getElementsByClassName("colorContainer")[0].style.borderBottomRightRadius = "0px"
  if(document.getElementById("pickerAnimation").style.display == "block") {
    document.getElementById("pickerAnimation").style.display = "none";
    document.getElementsByClassName("colorContainer")[0].style.borderBottomLeftRadius = "10px"
    document.getElementsByClassName("colorContainer")[0].style.borderBottomRightRadius = "10px"
  } else {
    document.getElementById("pickerAnimation").style.display = "block";
  }
}
function getColor(color) {
  if(checkColor == 1) {
    changeCheck(colorePrecedente);
    checkColor = 0;
  }
  colorePrecedente = color;
  document.getElementsByClassName("colorContainer")[0].style.backgroundColor = color;
  document.getElementById("pickerTitle").style.color = "white";
  document.getElementsByName(color)[0].style.display = "block";
  checkColor++;
}
function changeCheck(color) {
  document.getElementsByName(color)[0].style.display = "none";
}
