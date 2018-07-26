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
    menu_aggiungi.querySelector('input[name=nome]').value = "";
    menu_aggiungi.querySelector('input[name=descr]').value = "";
    menu_aggiungi.querySelector('input[name=n_scaffali]').value = 1;
    box_scaffali.innerHTML = "";
    chiama_menu_aggiungi()
}
function modifica_libreria() {
    var info_boxes = menu_info.getElementsByClassName("scatola_info");
    console.log(info_boxes);
    for(var i=0; i<info_boxes.length; i++){
        var info_box = info_boxes[i];
        info_box.style.display = "block";
        var info_p = info_box.getElementsByClassName("testo_scatola_info")[0];
        var input = document.createElement("input");
        input.value = info_p.innerHTML;
        var info_tooltip = info_box.getElementsByClassName("nome_scatola_info")[0];
        input.name = info_tooltip.innerHTML;
        if(info_tooltip.innerHTML === "colore etichetta"){
            input = color_picker(500);
        }
        if(info_tooltip.innerHTML === "numero scaffali"){
            input.type = "number";
        }
        info_box.replaceChild(input, info_p);
        info_tooltip.style.display = "block";
    }
    menu_info.getElementsByClassName("to_hide")[0].style.display = "none";
    menu_info.getElementsByClassName("to_show")[0].style.display = "block";
}

/*
|--------------------------------------------------------------|
|                                                              |
|  chiamate ajax                                               |
|                                                              |
|--------------------------------------------------------------|
*/

var pillole_libro = document.getElementById("pillole_libro");

function aggiorna_libreria(el, id) {
    function cb(r) {
        chiudi_menu_info();
        var result = JSON.parse(r.responseText);
        if(result["success"]){
            pillole_libro.querySelector('.pillola_libro[onclick="info_libreria(' + id + ')"]').innerHTML = result["pillole_libro"];
        }
    }
    a = {
        id : id,
        titolo : menu_info.querySelector("input[name = titolo]").value,
        descr : menu_info.querySelector("input[name = descrizione]").value,
        colore : menu_info.querySelector(".box_colorpicker div").style.backgroundColor,
        n_scaffali : menu_info.querySelector("input[name = 'numero scaffali']").value
    };
    chiama_post(a, "/librerie/php/aggiornalibreria.php", cb, el, 40);
}

function info_libro(id) {
    menu_info.style.transform = "translateX(-500px)";
    function cb (r) {
        menu_info.innerHTML = r.responseText;
    }
    chiama_get({id : id}, "/libri/php/infolibro.php", cb, menu_info, 120);
}

function info_libreria(id) {
    menu_info.style.transform = "translateX(-500px)";
    function cb(r) {
        menu_info.innerHTML = r.responseText;
    }
    chiama_get({id:id},"/librerie/php/infolibreria.php",cb,menu_info,120);
}

function elimina_libreria(el, id) {
    var cb = function (r) {
        chiudi_menu_info();
        console.log(r.responseText);
        if (r.responseText === "libreria eliminata") {
            var e = pillole_libro.querySelector('.pillola_libro[onclick="info_libreria(' + id + ')"]');
            e.parentNode.removeChild(e);
        }
    };
    chiama_post({id: id}, "/librerie/php/eliminalibreria.php", cb, el, 50);
}

function nuova_libreria(el) {
    function cb(r) {
        var div = document.createElement("DIV");
        div.innerHTML = r.responseText;
        console.log(r.responseText);
        pillole_libro.insertBefore(div.getElementsByTagName("DIV")[0], pillole_libro.getElementsByClassName("pillola_libro")[0]);
        reset_new_book();
    }
    var a = {
        nome : menu_aggiungi.querySelector('input[name=nome]').value,
        descr : menu_aggiungi.querySelector('input[name=descr]').value,
        scaffali : menu_aggiungi.querySelector('input[name=n_scaffali]').value,
        colore : menu_aggiungi.querySelector(".box_colorpicker div").style.backgroundColor
    };
    chiama_post(a, "/librerie/php/nuovalibreria.php", cb, el, 40);
}

function ordina(el, ordina) {
    function cb(r) {
        pillole_libro.innerHTML = r.responseText;
        el.parentElement.apri();
    }
    chiama_post({ordina: ordina}, "/librerie/php/ordina.php", cb, el, 35);
}

barra_ricerca.onkeyup = function (e) {
    if (e.keyCode == 13) {
        function cb(r) {
            pillole_libro.innerHTML = r.responseText;
        }
        chiama_get({ordina: barra_ricerca.value}, "/librerie/php/cerca.php", cb, document.querySelector("div[onclick=\"chiama_barra_ricerca()\"]"), 50);
    }
};
