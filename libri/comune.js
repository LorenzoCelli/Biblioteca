/*
|--------------------------------------------------------------|
|                                                              |
|  animazioni                                                  |
|                                                              |
|--------------------------------------------------------------|
*/

var barra_ricerca = document.getElementById("search_bar");

function chiama_barra_ricerca() {
    if (barra_ricerca.style.width === "" || barra_ricerca.style.width === "0px") {
        barra_ricerca.style.width = "500px";
    } else {
        barra_ricerca.style.width = "0px";
    }
}

var menu_aggiungi = document.getElementById("menu_aggiungi");

function chiama_menu_aggiungi() {
    if (!menu_aggiungi.is_open) {
        if(menu_info) close_info_menu();
        menu_aggiungi.style.transform = "translateX(-100%)";
        menu_aggiungi.is_open = true;
    }else{
        menu_aggiungi.style.transform = "translateX(0)";
        menu_aggiungi.is_open = false;
    }
}

var contenitore_principale = document.getElementById("main_container");

function chiama_menu_principe() {
    if (!contenitore_principale.is_open) {
        contenitore_principale.style.transform = "translateX(0)";
        contenitore_principale.is_open = true;
    } else {
        contenitore_principale.style.transform = "translateX(-300px)";
        contenitore_principale.is_open = false;
    }
}

var menu_info = document.getElementById("menu_info");

function close_info_menu() {
    menu_info.style.transform = "translateX(0)";
}

var l_img = document.createElement("IMG");
l_img.id = "caricamento";
l_img.src = "../imgs/loading.svg";

function caricamento_img(l) {
    l_img.style.width = l+"px";
    l_img.style.height = l+"px";
    return l_img;
}

/*
|--------------------------------------------------------------|
|  menu volante                                                |
|--------------------------------------------------------------|
*/

var menu_volanti = document.getElementsByClassName("menu_volante");
for (var i = 0; i<menu_volanti.length; i++){
    menu_volanti[i].apri = function () {
        if (this.style.height !== "0px" && this.style.height !== ""){
            this.style.height = "0px";
            return;
        }
        var h = 0;
        for (var i = 0; i<this.childNodes.length; i++){
            var o_h = this.childNodes[i].offsetHeight;
            h += o_h ? o_h : 0;
        }
        this.style.height = h+"px";
    }
}
function apri_menu_volante(nome) {
    document.getElementById("menu_volante_"+nome).apri();
}

/*
|--------------------------------------------------------------|
|                                                              |
|  chiamate ajax                                               |
|                                                              |
|--------------------------------------------------------------|
*/

function chiama_post(query_diz, file, callback, loading_el, loading_width) {
    if(loading_el) {
        var loading_inner = loading_el.innerHTML;
        loading_el.innerHTML = "";
        loading_el.appendChild(caricamento_img(loading_width));
    }
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            callback(this);
            if(loading_el) {
                loading_el.innerHTML =loading_inner;
            }
        }
    };
    xhttp.open("POST", file, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var a = "";
    for(var chiave in query_diz){
        a+= chiave+"="+query_diz[chiave]+"&";
    }
    xhttp.send(a);
}
function chiama_get(query_diz, file, callback, loading_el, loading_width) {
    if(loading_el) {
        var loading_inner = loading_el.innerHTML;
        loading_el.innerHTML = "";
        loading_el.appendChild(caricamento_img(loading_width));
    }
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if(loading_el) {
                loading_el.innerHTML = loading_inner;
            }
            callback(this);
        }
    };
    var a = "?";
    for(var chiave in query_diz){
        a+= chiave+"="+query_diz[chiave]+"&";
    }
    xhttp.open("GET", file+a, true);
    xhttp.send(null);
}
