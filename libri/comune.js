/*
|--------------------------------------------------------------|
|                                                              |
|  animazioni                                                  |
|                                                              |
|--------------------------------------------------------------|
*/



function stati(el, funz1, funz2, stato){
    if(!stato) stato = "stato";
    if(el[stato]){
        funz2();
        el[stato] = false;
    }else{
        funz1();
        el[stato] = true;
    }
}

function espandi_pillole() {
    stati(pillole_libro, function () {
            var pillole = pillole_libro.getElementsByClassName("pillola_libro");
            for(var i=0; i<pillole.length; i++){
                pillole[i].style.width = "100%";
            }
        },function () {
            var pillole = pillole_libro.getElementsByClassName("pillola_libro");
            for(var i=0; i<pillole.length; i++){
                pillole[i].style.width = "auto";
            }
        }
    )
}

var prima_barra = document.getElementById("barra_ricerca");
var seconda_barra = document.getElementById("seconda_barra_ricerca");
var barra_attiva = prima_barra;
var tipo_display = "block";

if(prima_barra && seconda_barra) {
    prima_barra.apri = function () {
        prima_barra["stato"] = true;
        prima_barra.style.width = "500px";
    };
    prima_barra.chiudi = function () {
        prima_barra["stato"] = false;
        prima_barra.style.width = "0";
    };
    seconda_barra.apri = function () {
        seconda_barra["stato"] = true;
        seconda_barra.style.width = "100%";
        seconda_barra.style.height = "50px";
        seconda_barra.style.border = "1px solid #efefef";
        seconda_barra.style.marginBottom = "10px";
    };
    seconda_barra.chiudi = function () {
        seconda_barra["stato"] = false;
        seconda_barra.style.width = "0";
        seconda_barra.style.height = "0";
        seconda_barra.style.border = "none";
        seconda_barra.style.marginBottom = "0";
    };

    function chiama_barra_ricerca(el) {
        stati(barra_attiva, barra_attiva.apri, barra_attiva.chiudi)
    }

    function controlla_barra() {
        if (window.innerWidth > 810) {
            barra_attiva = prima_barra;
            seconda_barra.chiudi();
        } else {
            barra_attiva = seconda_barra;
            prima_barra.chiudi();
        }
    }

    controlla_barra();
    window.onresize = controlla_barra;
}

var menu_aggiungi = document.getElementById("menu_aggiungi");

function chiama_menu_aggiungi() {
    stati(menu_aggiungi, function () {
        if(menu_info) chiudi_menu_info();
        menu_aggiungi.style.transform = "translateX(-100%)";
    },function () {
        menu_aggiungi.style.transform = "translateX(0)";
        if(typeof variable !== 'undefined') azzera_menu_aggiungi();
    })
}

var contenitore_principale = document.getElementById("main_container");

function chiama_menu_principe() {
    stati(contenitore_principale, function () {
        contenitore_principale.style.transform = "translateX(0)";
    }, function () {
        contenitore_principale.style.transform = "translateX(-300px)";
    })
}


var menu_info = document.getElementById("menu_info");
var menu_info2 = document.getElementById("menu_info2");

function chiudi_menu_info() {
    menu_info.style.transform = "translateX(0)";
}

if(typeof color_picker !== "undefined") {
    var box_color_picker = menu_aggiungi.getElementsByClassName("box_colorpicker")[0];
    var new_picker = color_picker(400, menu_aggiungi.getElementsByClassName("etichetta")[0]);
    box_color_picker.parentElement.replaceChild(new_picker, box_color_picker);
    box_color_picker = new_picker;

    function chiama_color_picker() {
        stati(box_color_picker, function () {
            box_color_picker.style.width = "100%";
            box_color_picker.style.height = "40px";
        }, function () {
            box_color_picker.style.width = "0";
            box_color_picker.style.height = "0";
        });
    }
}

function apri_menu_volante(nome) {
    var menu = document.getElementById("menu_volante_"+nome);
    stati(this, function () {
        var h = 0;
        for (var i = 0; i<menu.childNodes.length; i++){
            var o_h = menu.childNodes[i].offsetHeight;
            h += o_h ? o_h : 0;
        }
        menu.style.height = h+"px";
    }, function () {
        menu.style.height = "0px";
    })
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
        var loading_inner = loading_el.innerHTML;
        loading_el.innerHTML = "";
        loading_el.appendChild(caricamento_img(loading_width));
    }
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function (){
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
