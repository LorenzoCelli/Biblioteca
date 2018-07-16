var s_counter = document.querySelector("input[name=n_scaffali]");
var box_scaffali = document.getElementsByClassName("box_scaffali")[0];

function nuovo_scaffale() {
    if(s_counter.value>249) return;
    s_counter.value ++;
    var sc = scaffale();
    console.log();
    box_scaffali.appendChild(sc);
    sc.style.height = "0px";
    sc.style.backgroundColor = "#dedede";
    window.requestAnimationFrame(function (time) {
        sc.style.height = "0px";
        sc.style.backgroundColor = "#dedede";
        window.requestAnimationFrame(function (time1) {
            sc.style.height = "70px";
            sc.style.backgroundColor = "white";
        });
    });
    check();
}
function rimuovi_scaffale() {
    if(s_counter.value<2) return;
    s_counter.value --;
    sc = box_scaffali.childNodes[box_scaffali.childNodes.length-1];
    window.requestAnimationFrame(function (time) {
        sc.style.height = "70px";
        sc.style.backgroundColor = "white";
        window.requestAnimationFrame(function (time1) {
            sc.style.height = "0px";
            sc.style.backgroundColor = "#dedede";
            window.setTimeout(function (time2) {
                box_scaffali.removeChild(sc);
            }, 150);
        });
    });
}
function check() {
    if(parseInt(s_counter.value) !== (box_scaffali.childNodes.length+1)){
        nuovi_scaffali();
    }
}
function scaffale() {
    var div = document.createElement("DIV");
    div.className = "scaffale";
    return div;
}
function nuovi_scaffali() {
  var count = s_counter.value;
  if(count>250 || count<1) return;
  box_scaffali.innerHTML = "";
  for (var i = 0; i < count-1; i++) {
    box_scaffali.appendChild(scaffale());
  }
  contatoreScaffali = count;
}

function reset_new_book() {
    new_menu.querySelector('input[name=nome]').value = "";
    new_menu.querySelector('input[name=descr]').value = "";
    new_menu.querySelector('input[name=n_scaffali]').value = 1;
    box_scaffali.innerHTML = "";
    slide_new_menu()
}

var content = document.getElementsByClassName("content")[0];

function nuova_libreria(el) {
    el.innerHTML = "";
    el.appendChild(loading_img(40));
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var div = document.createElement("DIV");
            div.innerHTML = this.responseText;
            content.insertBefore(div.getElementsByTagName("DIV")[0], content.getElementsByClassName("book_container")[0]);
            reset_new_book();
        }
    };
    xhttp.open("POST", "nuovalibreria.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    var nome = new_menu.querySelector('input[name=nome]').value;
    var descr = new_menu.querySelector('input[name=descr]').value;
    var scaffali = new_menu.querySelector('input[name=n_scaffali]').value;
    var colore = pointer.style.backgroundColor;

    var a = "nome="+nome+"&descr="+descr+"&scaffali="+scaffali+"&colore="+colore;
    xhttp.send(a);
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


var container = document.getElementById("box_colorpicker");
var pointer = container.getElementsByTagName("DIV")[0];
var w = container.offsetWidth;

var step = w/6;
var colori =[
    [0,2,1],
    [2,0,-1],
    [2,1,1],
    [1,2,-1],
    [1,0,1],
    [0,1,-1]
];

function ciao(ev) {
    var l = ev.clientX-(getX(container)-400)-pointer.offsetWidth/2;
    //pointer.style.transform = "translateX("+l+"px)";
    pointer.style.left = l+"px";
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
    pointer.style.backgroundColor = "rgb("+a[0]+","+a[1]+","+a[2]+")";
}
function getX(element) {
    var xPosition = 0;
    while(element) {
        xPosition += (element.offsetLeft - element.scrollLeft + element.clientLeft);
        element = element.offsetParent;
    }
    return xPosition;
}

pointer.onmousedown = dragMouseDown;
var pos1 = 0, pos2 = 0;

function dragMouseDown(e) {
    e = e || window.event;
    e.preventDefault();
    pos2 = e.clientX;
    document.onmouseup = closeDragElement;
    document.onmousemove = elementDrag;
}

function elementDrag(e) {
    e = e || window.event;
    e.preventDefault();
    pos1 = pos2 - e.clientX;
    pos2 = e.clientX;
    l = pointer.offsetLeft - pos1;
    if(l<0 || l>w-pointer.offsetWidth) return;
    pointer.style.left = l + "px";

    l = l+pointer.offsetWidth/2;
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
    pointer.style.backgroundColor = "rgb("+a[0]+","+a[1]+","+a[2]+")";
}

function closeDragElement() {
    document.onmouseup = null;
    document.onmousemove = null;
}