/*
|--------------------------------------------------------------|
|                                                              |
|  animazioni                                                  |
|                                                              |
|--------------------------------------------------------------|
*/

var search_bar = document.getElementById("search_bar");

function slide_search_bar() {
    if (search_bar.style.width === "" || search_bar.style.width === "0px") {
        search_bar.style.width = "500px";
    } else {
        search_bar.style.width = "0px";
    }
}

var little_menu = document.getElementById("menu_ordina");

function show_little_menu() {
    if (little_menu.style.height === "" || little_menu.style.height === "0px") {
        little_menu.style.display = "block";
        little_menu.style.height = "auto";
    } else {
        little_menu.style.display = "none";
        little_menu.style.height = "0px";
    }
}

var menu_account = document.getElementById("menu_account");

function show_menu_account() {
    if (menu_account.style.display === "" || menu_account.style.display === "none") {
        menu_account.style.display = "block";
    } else {
        menu_account.style.display = "none";
    }
}

var new_menu = document.getElementById("menu_aggiungi");

function slide_new_menu() {
    if (!new_menu.is_open) {
        close_info_menu();
        new_menu.style.transform = "translateX(-100%)";
        new_menu.is_open = true;
    } else {
        new_menu.style.transform = "translateX(0)";
        new_menu.is_open = false;
    }
}

var main_menu = document.getElementById("main_container");

function slide_main_menu() {
    if (!main_menu.is_open) {
        main_menu.style.transform = "translateX(0)";
        main_menu.is_open = true;
    } else {
        main_menu.style.transform = "translateX(-300px)";
        main_menu.is_open = false;
    }
}

var info_menu = document.getElementById("menu_info");

function close_info_menu() {
    info_menu.style.transform = "translateX(0)";
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
|                                                              |
|  chiamate ajax                                               |
|                                                              |
|--------------------------------------------------------------|
*/

function chiama_post(query_diz, file, callback, loading_el, loading_width) {
    if(loading_el) {
        loading_el.innerHTML = "";
        loading_el.appendChild(caricamento_img(loading_width));
    }
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            callback(this);
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
        loading_el.innerHTML = "";
        loading_el.appendChild(caricamento_img(loading_width));
    }
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
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
