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

function elimina_libreria(el, id) {
    el.innerHTML = "";
    el.appendChild(loading_img(50));
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            close_info_menu();
            info_menu.innerHTML = this.responseText;
            if (this.responseText === "libreria eliminata") {
                var e = document.querySelector('.book_container[onclick="fill_info_library(' + id + ')"]');
                e.parentNode.removeChild(e);
            }
        }
    };
    xhttp.open("POST", "eliminalibreria.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id="+id);
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

function modifica_libreria() {
    var info_boxes = info_menu.getElementsByClassName("info_box");
    console.log(info_boxes);
    for(var i=0; i<info_boxes.length; i++){
        var info_box = info_boxes[i];
        info_box.style.display = "block";
        var info_p = info_box.getElementsByClassName("info_p")[0];
        var input = document.createElement("input");
        input.value = info_p.innerHTML;
        var info_tooltip = info_box.getElementsByClassName("info_tooltip")[0];
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

var container = document.getElementsByClassName("box_colorpicker")[0];
container.parentElement.replaceChild(color_picker(400),container);

