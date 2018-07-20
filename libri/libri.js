/*
|--------------------------------------------------------------|
|                                                              |
|  Autocompilazione isbn, titolo, autore                       |
|                                                              |
|--------------------------------------------------------------|
*/

var preview_img = document.getElementById("img_aggiungi");
var img_url = new_menu.querySelector('input[name=img_url]');
var isbn = new_menu.querySelector('input[name=isbn]');
var titolo = new_menu.querySelector('input[name=titolo]');
var autore = new_menu.querySelector('input[name=autore]');
var descr = new_menu.querySelector('textarea[name=descr]');

isbn.oninput = function (){
    var l = this.value.toString().length;
    if(l<10 || l>13) return;
    request_isbn_data(isbn_menu_options, "q=isbn:"+this.value);
};
titolo.onblur = function () {
    if(this.value.length < 1) return;
    request_isbn_data(title_menu_options, "q=intitle:"+this.value);
};
autore.onblur = function () {
    if(this.value.length < 1) return;
    request_isbn_data(author_menu_options, "q=inauthor:"+this.value);
};

var isbn_menu_options = document.getElementById("isbn_menu_options");
var title_menu_options = document.getElementById("title_menu_options");
var author_menu_options = document.getElementById("author_menu_options");

var def_list = [img_url, isbn, titolo, autore, descr];
defocussers("isbn", function (){ isbn_menu_options.innerHTML = ""});
defocussers("titolo", function (){ title_menu_options.innerHTML = ""});
defocussers("autore", function (){ author_menu_options.innerHTML = ""});


function defocussers(avoid_name, func){
    for(var i = 0; i<def_list.length; i++){
        var el = def_list[i];
        if(el.name !== avoid_name){
            el.addEventListener("focus", func);
        }
    }
}

function request_isbn_data(menu_options, query) {
    menu_options.innerHTML = "";
    menu_options.appendChild(isbn_menu_option(null,null,null,true));
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            menu_options.innerHTML = "";
            var r = JSON.parse(this.response);
            if(!r.items){
                console.log("nothing found"); return;
            }
            if (r.totalItems == 1){
                fill_isbn_data(r.items[0].volumeInfo)
            }else{
                var items = r.items;
                menu_options.appendChild(isbn_hide_option());
                for(var i = 0; i< items.length; i++){
                    var titolo = items[i].volumeInfo.title;
                    var autore = authors(items[i].volumeInfo);
                    menu_options.appendChild(isbn_menu_option(titolo, autore, items[i].volumeInfo));
                }
            }
        }else{
            menu_options.innerHTML = "";
        }
    };
    xhttp.open("GET", "https://www.googleapis.com/books/v1/volumes?"+query, true);
    xhttp.send();
}

function fill_isbn_data(volumeInfo) {
    isbn.value = parseInt(volumeInfo.industryIdentifiers[0]["identifier"]);
    titolo.value = volumeInfo.title;
    autore.value = authors(volumeInfo);
    if('description' in volumeInfo){
        descr.value = volumeInfo.description;
    }else{
        descr.value = "";
    }
    if('imageLinks' in volumeInfo) {
        preview_img.style.backgroundImage = "url('" + volumeInfo.imageLinks.thumbnail + "')";
        img_url.value = volumeInfo.imageLinks.thumbnail;
    }else{
        preview_img.style.backgroundImage = "url('')";
    }
    if('categories' in volumeInfo) {
        generi.innerHTML = '<div class="pillola_genere" contenteditable="true"><img onclick="nuovo_genere(this)" src="../imgs/piu_pillola.svg"></div>';
        for(var category in volumeInfo.categories){
            generi.append(grigio_genere(volumeInfo.categories[category]));
        }
    }
}

function authors(volumeInfo) {
    if(!("authors" in volumeInfo)) return "";
    console.log(volumeInfo);
    var authors = "";
    for (var i = 0; i < volumeInfo.authors.length; i++) {
        authors += volumeInfo.authors[i];
        if (i !== volumeInfo.authors.length - 1) authors += ", ";
    }
    return authors;
}

function isbn_menu_option(titolo, autore, volumeInfo,l){ // <div class="opzione_scatola_aggiungi"><b>Giovanninoioino</b> autore tuo padre</div>
    var div = document.createElement("DIV");
    div.className = "isbn_menu_option";
    if(l){
        div.appendChild(caricamento_img(40));
    }else{
        div.innerHTML = "<b>"+titolo+"</b> "+autore;
        div.vi = volumeInfo;
        div.onclick = function () { this.parentElement.innerHTML = ""; fill_isbn_data(this.vi) };
    }
    return div;
}

function isbn_hide_option(){
    var div = document.createElement("DIV");
    div.className = "isbn_menu_option";
    div.style.fontStyle = "italic";
    div.style.height = "30px";
    div.style.padding = "0";
    div.innerHTML = "<img src='../imgs/nascondi.svg' style='height: 30px; width: 30px'><div style='display: inline-block; height: 30px; line-height: 30px; vertical-align: top'>nascondi suggerimenti</div>";
    div.onclick = function () { this.parentElement.innerHTML = "" };
    return div;
}

/*
|--------------------------------------------------------------|
|                                                              |
|  Chiamate ajax                                               |
|                                                              |
|--------------------------------------------------------------|
*/

function info_libro(id) {
    info_menu.style.transform = "translateX(-500px)";
    function cb (r) {
        info_menu.innerHTML = r.responseText;
    }
    chiama_get({id : id}, "/libri/php/infolibro.php", cb, info_menu, 120);
}

function modifica_libro(id_libro) {
    var edit = info_menu.getElementsByClassName("testo_scatola_info");
    while (edit.length) {
        var input = document.createElement("INPUT");
        var tt = edit[0].parentElement.getElementsByClassName("nome_scatola_info")[0];
        tt.style.display = "inline-block";
        if (tt.innerText === "descrizione") {
            input = document.createElement("TEXTAREA")
        }
        if (tt.innerText === "libreria") {
            input = librerie_select();
        }
        if (tt.innerText === "scaffale") {
            input = document.createElement("SELECT");

        }
        input.name = tt.innerText;
        var value = edit[0].innerHTML;
        input.value = value;
        if (tt.innerText === "generi") {
            var div = document.createElement("DIV");
            div.innerHTML = '<div class="pillola_genere" contenteditable="true"><img onclick="nuovo_genere(this)" src="../imgs/piu_pillola.svg"></div>';
            gi = edit[0].innerHTML.split(",");
            for (var i = 0; i<gi.length; i++){
                if(gi[i] === "nessuno") continue;
                div.appendChild(grigio_genere(gi[i]))
            }
            input = div;
        }
        edit[0].parentElement.replaceChild(input, edit[0]);
        if (tt.innerText === "scaffale"){
            info_menu.querySelector('select[name=libreria]').onchange();
            input.value = value;
        }
    }
    var salva = document.createElement("BUTTON");
    salva.innerText = "salva modifiche";
    salva.onclick = function () { aggiorna_libro(id_libro, this) };
    info_menu.appendChild(salva);
    var annulla = document.createElement("BUTTON");
    annulla.innerText = "annulla modifiche";
    annulla.onclick = function () { info_libro(id_libro) };
    info_menu.appendChild(annulla);
}

function aggiorna_libro(id, el) {
    function cb(r) {
        info_libro(id);
        document.querySelector('.pillola_libro[onclick="info_libro(' + id + ')"]').innerHTML = r.responseText;
    }
    var scatole_generi = info_menu.querySelectorAll('.pillola_genere[contenteditable=false]');
    var gi = trova_generi(scatole_generi);
    var a = {
        id : id,
        titolo : info_menu.querySelector('input[name=titolo]').value,
        autore : info_menu.querySelector('input[name=autore]').value,
        isbn : info_menu.querySelector('input[name=isbn]').value,
        descr : info_menu.querySelector('textarea[name=descrizione]').value,
        libreria : info_menu.querySelector('select[name=libreria]').value,
        scaffale : info_menu.querySelector('select[name=scaffale]').value,
        img_url : encodeURIComponent(info_menu.querySelector('input[name=img_url]').value),
        generi : gi
    };
    chiama_post(a,"/libri/php/aggiornalibro.php", cb, el, 40);
}

function nuovo_libro(el) {
    function cb(r) {
        slide_new_menu();
        new_menu.innerHTML = r.responseText;
    }
    var scatole_generi = new_menu.querySelectorAll('.pillola_genere[contenteditable=false]');
    var generi = trova_generi(scatole_generi);
    var a  = {
        titolo : new_menu.querySelector('input[name=titolo]').value,
        autore : new_menu.querySelector('input[name=autore]').value,
        isbn : new_menu.querySelector('input[name=isbn]').value,
        descr : new_menu.querySelector('textarea[name=descr]').value,
        nome_libreria : new_menu.querySelector('select[name=nome_libreria]').value,
        scaffale : new_menu.querySelector('select[name=scaffale]').value,
        img_url : encodeURIComponent(new_menu.querySelector('input[name=img_url]').value),
        generi : generi
    };
    chiama_post(a,"libri/php/nuovolibro.php", cb, el, 40);
}

var pillole_libro = document.getElementById("pillole_libro");

function ordina(el, ordina) {
    function cb(r) {
        console.log(r.responseText);
        pillole_libro.innerHTML = r.responseText;
        el.parentElement.apri();
    }
    chiama_post({ordina: ordina}, "/libri/php/ordina.php", cb, el, 35);
}

function elimina_libro(id, el) {
    function cb(r) {
        close_info_menu();
        info_menu.innerHTML = r.responseText;
        if (r.responseText === "libro eliminato") {
            var e = document.querySelector('.pillola_libro[onclick="info_libro(' + id + ')"]');
            e.parentNode.removeChild(e);
        }
    }
    chiama_post({id : id}, "/libri/php/eliminalibro.php", cb, el, 50);
}

function trova_generi(scatole_generi) {
    var generi = "";
    for(var i = 0; i<scatole_generi.length; i++){
        generi += scatole_generi[i].innerText;
        if(i!==scatole_generi.length-1) generi += ",";
    }
    return generi;
}

function librerie_select() {
    selectBox = document.createElement("SELECT");
    selectBox.name = "nome_libreria";
    option = document.createElement("option");
    option.textContent = "nessuna libreria";
    selectBox.add(option);
    for (prop in libreria) {
        option = document.createElement("option");
        option.textContent = prop;
        selectBox.add(option);
    }
    selectBox.onchange = function () { scaffali(this, info_menu.querySelector('select[name=scaffale]')); };
    return selectBox;
}

function scaffali(libreria_select, scaffale_select) {
    scaffale_select.disabled = libreria_select.value === "nessuna libreria";
    var num_scaffali = libreria[libreria_select.value];
    scaffale_select.innerHTML = "";
    for (var i = 1; i <= num_scaffali; i++) {
        scaffale_select.innerHTML += "<option value='" + i + "'>" + i + "</option>";
    }
}

var generi = document.getElementById("generi");

function nuovo_genere(el) {
    if(el.parentElement.innerText.replace(/\s/g,'') === "") return;
    var gen = genere();
    gen.contentEditable = true;
    gen.add_img.onclick = function () { nuovo_genere(this) };
    el.parentElement.parentElement.insertBefore(gen, el.parentElement);
    el.parentElement.contentEditable = false;
    el.style.transform = "rotate(45deg)";
    el.parentElement.style.backgroundColor = "#f6f6f6";
    el.onclick = function () {
        this.parentElement.parentElement.removeChild(this.parentElement);
    }
}

function grigio_genere(text) {
    var div = genere();
    div.add_img.onclick = function () { this.parentElement.parentElement.removeChild(this.parentElement) };
    div.add_img.style.transform = "rotate(45deg)";
    div.style.backgroundColor = "#f6f6f6";
    div.appendChild(document.createTextNode(text));
    div.contentEditable = false;
    return div;
}

function genere(){
    var div = document.createElement("DIV");
    div.className = "pillola_genere";
    var img = document.createElement("IMG");
    img.src = "../imgs/piu_pillola.svg";
    div.add_img = img;
    div.append(img);
    return div;
}

/*
|--------------------------------------------------------------|
|                                                              |
|  ISBN scan                                                   |
|                                                              |
|--------------------------------------------------------------|
*/

function mostra_scanner() {
    Quagga.init({
        inputStream: {
            type: "LiveStream",
            constraints: {
                width: {min: 640},
                height: {min: 480},
                aspectRatio: {min: 1, max: 100},
                facingMode: "environment" // or user
            },
            target: document.querySelector('#finestra_scan')
        },
        locator: {
            patchSize: "medium",
            halfSample: true
        },
        numOfWorkers: 2,
        frequency: 10,
        decoder: {
            readers: [{
                format: "ean_reader",
                config: {}
            }]
        },
        locate: true
    }, function (err) {
        if (err) {
            console.log(err);
            return
        }
        console.log("Initialization finished. Ready to start");
        Quagga.start();
    });
}
Quagga.onProcessed(function(result) {
    var drawingCtx = Quagga.canvas.ctx.overlay,
        drawingCanvas = Quagga.canvas.dom.overlay;

    if (result) {
        if (result.boxes) {
            drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));
            result.boxes.filter(function (box) {
                return box !== result.box;
            }).forEach(function (box) {
                Quagga.ImageDebug.drawPath(box, {x: 0, y: 1}, drawingCtx, {color: "green", lineWidth: 2});
            });
        }

        if (result.box) {
            Quagga.ImageDebug.drawPath(result.box, {x: 0, y: 1}, drawingCtx, {color: "#00F", lineWidth: 2});
        }

        if (result.codeResult && result.codeResult.code) {
            Quagga.ImageDebug.drawPath(result.line, {x: 'x', y: 'y'}, drawingCtx, {color: 'red', lineWidth: 3});
        }
    }
});

var lastResult = "";

Quagga.onDetected(function(result) {
    var code = result.codeResult.code;

    if (lastResult !== code) {
        lastResult = code;
        isbn.value = code;
        isbn.oninput();
    }
});

isbn.onkeyup = function (e) {
    if (e.keyCode == 13) {
        isbn.oninput();
    }
};
