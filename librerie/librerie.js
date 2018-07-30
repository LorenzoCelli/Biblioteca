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
            input.style.width = "100%";
            input.style.height = "40px";
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
|  Riduzione pillole                                           |
|                                                              |
|--------------------------------------------------------------|
*/

var pillole_libro = document.getElementById("pillole_libro");
var pillola_libro = pillole_libro.getElementsByClassName("pillola_libro");

var f_a = 23;
var f_t = 25;

function f(){
    for (var i = 0; i < pillola_libro.length; i++) {
        var pillola = pillola_libro[i];
        var testo = pillola.getElementsByClassName("testo_pillola_libro")[0];
        var w = pillola.offsetWidth;
        var h = pillola.offsetHeight;
        var autore = testo.getElementsByTagName("div")[1];
        var titolo = testo.getElementsByTagName("div")[0];
        autore.style.fontSize = f_a+"px";
        titolo.style.fontSize = f_t+"px";
        if(testo.offsetWidth > w+3 || testo.offsetHeight> h+3){
            console.log(titolo.innerHTML, testo.offsetWidth, w);
            var k = 5;
            while(testo.offsetHeight>h || testo.offsetWidth > w){
                autore.style.fontSize = (f_a - k)+"px";
                titolo.style.fontSize = (f_t - k)+"px";
                k += 5;
                if(k>f_t) break;
            }
            console.log(k);
        }
    }
}
f();

var resizeTimer;
window.onresize = function(e) {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
        f();
    }, 250);
};

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
            pillole_libro.querySelector('.pillola_libro[onclick="info_libreria(' + id + ')"]').innerHTML = result["content"];
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
        apri_menu_volante(el.parentElement.id.replace("menu_volante_",""));
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
