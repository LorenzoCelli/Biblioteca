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
function modifica_libreria() {
    var info_boxes = info_menu.getElementsByClassName("scatola_info");
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
    info_menu.getElementsByClassName("to_hide")[0].style.display = "none";
    info_menu.getElementsByClassName("to_show")[0].style.display = "block";
}

var container = document.getElementsByClassName("box_colorpicker")[0];
container.parentElement.replaceChild(color_picker(400),container);

/*
|--------------------------------------------------------------|
|                                                              |
|  chiamate ajax                                               |
|                                                              |
|--------------------------------------------------------------|
*/

var content = document.getElementById("pillole_libro");

function aggiorna_libreria(el, id) {
    function cb(r) {
        close_info_menu();
        var result = JSON.parse(r.responseText);
        if(result["success"]){
            content.querySelector('.pillola_libro[onclick="info_libreria(' + id + ')"]').innerHTML = result["content"];
        }
    }
    a = {
        id : id,
        titolo : info_menu.querySelector("input[name = titolo]").value,
        descr : info_menu.querySelector("input[name = descrizione]").value,
        colore : info_menu.querySelector(".box_colorpicker div").style.backgroundColor,
        n_scaffali : info_menu.querySelector("input[name = 'numero scaffali']").value
    };
    chiama_post(a, "/librerie/php/aggiornalibreria.php", cb, el, 40);
}

function fill_info_book2(id_libro) {
    document.getElementById("info_book_menu").innerHTML = "";
    document.getElementById("info_book_menu").appendChild(caricamento_img(120));
    document.getElementById("info_book_menu").style.transform = "translateX(-500px)";
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("info_book_menu").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "/main/infolibro.php" + "?id=" + id_libro, true);
    xhttp.send(null);
}

function info_libreria(id) {
    info_menu.style.transform = "translateX(-500px)";
    function cb(r) {
        info_menu.innerHTML = r.responseText;
    }
    chiama_get({id:id},"/librerie/php/infolibreria.php",cb,info_menu,120);
}

function elimina_libreria(el, id) {
    var cb = function (r) {
        close_info_menu();
        console.log(r.responseText);
        if (r.responseText === "libreria eliminata") {
            var e = content.querySelector('.pillola_libro[onclick="info_libreria(' + id + ')"]');
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
        content.insertBefore(div.getElementsByTagName("DIV")[0], content.getElementsByClassName("pillola_libro")[0]);
        reset_new_book();
    }
    var a = {
        nome : new_menu.querySelector('input[name=nome]').value,
        descr : new_menu.querySelector('input[name=descr]').value,
        scaffali : new_menu.querySelector('input[name=n_scaffali]').value,
        colore : new_menu.querySelector(".box_colorpicker div").style.backgroundColor
    };
    chiama_post(a, "/librerie/php/nuovalibreria.php", cb, el, 40);
}

