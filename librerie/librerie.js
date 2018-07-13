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
  var elimina = document.getElementsByClassName("scaffale").length;
  for (var i = 0; i < elimina-1; i++) {
    document.getElementsByClassName("containerScaffali")[0].removeChild(document.getElementsByClassName("scaffale")[1]);
  }
  for (var i = 0; i < count-1; i++) {
    document.getElementsByClassName("containerScaffali")[0].appendChild(library(libraryImg));
  }
  contatoreScaffali = count;
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

function openLibrary() {
  document.getElementById("info_menu").style.transform = "translateX(-500px)";
}
function closeLibrary() {
    document.getElementById("info_menu").style.transform = "translateX(0)";
}

function fill_info_library(id_libreria) {
    document.getElementById("info_menu").innerHTML = "";
    document.getElementById("info_menu").appendChild(loading_img(120));
    document.getElementById("info_menu").style.transform = "translateX(-500px)";
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("info_menu").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "infolibrerie.php" + "?id=" + id_libreria, true);
    xhttp.send(null);
}

function fill_info_book2(id_libro) {
    document.getElementById("info_book_menu").innerHTML = "";
    document.getElementById("info_book_menu").appendChild(loading_img(120));
    document.getElementById("info_book_menu").style.transform = "translateX(-500px)";
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("info_book_menu").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "../main/infolibro.php" + "?id=" + id_libro, true);
    xhttp.send(null);
}

var l_img = document.createElement("IMG");
l_img.id = "loading";
l_img.src = "../imgs/loading.svg";

function loading_img(l) {
    l_img.alt = "loading..";
    l_img.style.width = l+"px";
    l_img.style.height = l+"px";
    return l_img;
}

/*
color picker
*/

var w = 200;
var container = document.getElementById("container");
var pointer = document.getElementById("pointer");
var cubo = document.getElementById("cubo");

var step = w/6;
var colori =[
    [0,2,1],
    [2,1,-1],
    [2,1,1],
    [1,2,-1],
    [1,0,1],
    [0,1,-1]
];

function ciao(ev) {
    var l = ev.clientX-(getX(container)-400);
    pointer.style.transform = "translateX("+l+"px)";
    var s = Math.floor(l/step);
    var rest = l/step-s;
    var colore = colori[s];
    var a = [];
    a[colore[0]] = 255;
    if(colore[2]>0){
        a[colore[1]] = 255*rest;
    }else{
        a[colore[1]] = 255-255*rest;
    }
    for (var i = 0; i<3; i++){
        if(!a[i]){
            a[i] = 0;
        }
    }
    cubo.style.backgroundColor = "rgb("+a[0]+","+a[1]+","+a[2]+")";
}
function getX(element) {
    var xPosition = 0;
    while(element) {
        xPosition += (element.offsetLeft - element.scrollLeft + element.clientLeft);
        element = element.offsetParent;
    }
    return xPosition;
}
