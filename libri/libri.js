/*
|--------------------------------------------------------------|
|                                                              |
|  Autocompilazione isbn, titolo, autore                       |
|                                                              |
|--------------------------------------------------------------|
*/

var preview_img = document.getElementById("img_aggiungi");
var img_url = menu_aggiungi.querySelector('input[name=img_url]');
var isbn = menu_aggiungi.querySelector('input[name=isbn]');
var titolo = menu_aggiungi.querySelector('input[name=titolo]');
var autore = menu_aggiungi.querySelector('input[name=autore]');
var descr = menu_aggiungi.querySelector('textarea[name=descr]');

isbn.oninput = function (){
    var l = this.value.toString().length;
    if(l<10 || l>13) return;
    richiedi_dati(isbn_menu_options, "q=isbn:"+this.value);
};
titolo.onblur = function () {
    if(this.value.length < 1) return;
    richiedi_dati(title_menu_options, "q=intitle:"+this.value);
};
autore.onblur = function () {
    if(this.value.length < 1) return;
    richiedi_dati(author_menu_options, "q=inauthor:"+this.value);
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

function richiedi_dati(menu_suggerimenti, query) {
    menu_suggerimenti.innerHTML = "";
    menu_suggerimenti.appendChild(suggerimento(null,null,null,true));
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            menu_suggerimenti.innerHTML = "";
            var r = JSON.parse(this.response);
            if(!r.items){
                console.log("nothing found"); return;
            }
            if (r.totalItems == 1){
                riempi_dati(r.items[0].volumeInfo)
            }else{
                var items = r.items;
                menu_suggerimenti.appendChild(suggerimento_nascondi());
                for(var i = 0; i< items.length; i++){
                    var titolo = items[i].volumeInfo.title;
                    var autore = authors(items[i].volumeInfo);
                    menu_suggerimenti.appendChild(suggerimento(titolo, autore, items[i].volumeInfo));
                }
            }
        }else{
            menu_suggerimenti.innerHTML = "";
        }
    };
    xhttp.open("GET", "https://www.googleapis.com/books/v1/volumes?"+query, true);
    xhttp.send();
}

function riempi_dati(volumeInfo) {
    isbn.value = parseInt(volumeInfo.industryIdentifiers[1]["identifier"]);
    titolo.value = volumeInfo.title;
    autore.value = authors(volumeInfo);
    if('description' in volumeInfo){
        descr.value = volumeInfo.description;
    }else{
        descr.value = "";
    }
    if('imageLinks' in volumeInfo) {
        img_url.value = volumeInfo.imageLinks.thumbnail;
        img_url.onchange();
    }else{
        img_url.value = '';
        img_url.onchange();
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
    var authors = "";
    for (var i = 0; i < volumeInfo.authors.length; i++) {
        authors += volumeInfo.authors[i];
        if (i !== volumeInfo.authors.length - 1) authors += ", ";
    }
    return authors;
}

function suggerimento(titolo, autore, volumeInfo, l){
    var div = document.createElement("DIV");
    div.className = "suggerimento";
    if(l){
        div.appendChild(caricamento_img(40));
    }else{
        div.innerHTML = "<b>"+titolo+"</b> "+autore;
        div.vi = volumeInfo;
        div.onclick = function () { this.parentElement.innerHTML = ""; riempi_dati(this.vi) };
    }
    return div;
}

function suggerimento_nascondi(){
    var div = document.createElement("DIV");
    div.className = "suggerimento";
    div.style.fontStyle = "italic";
    div.style.height = "30px";
    div.style.padding = "0";
    div.innerHTML = "<img src='../imgs/nascondi.svg' style='height: 30px; width: 30px'><div style='display: inline-block; height: 30px; line-height: 30px; vertical-align: top'>nascondi suggerimenti</div>";
    div.onclick = function () { this.parentElement.innerHTML = "" };
    return div;
}

img_url.onchange  = function () {
    preview_img.imposta(this.value);
};
img_url.oninput = img_url.onchange;

preview_img.imposta = function (url) {
    if(url === "") url = "/imgs/librosconosciuto.svg";
    this.style.backgroundImage = "url("+url+")";
};

/*
|--------------------------------------------------------------|
|                                                              |
|  Riduzione pillole                                           |
|                                                              |
|--------------------------------------------------------------|
*/

var pillole_libro = document.getElementById("pillole_libro");
var pillola_libro = pillole_libro.getElementsByClassName("pillola_libro");
var padding_testo = [20, 20, 20, 150];
/*function f() {
    for (var i = 0; i < pillola_libro.length; i++) {
        var pillola = pillola_libro[i];
        var testo = pillola.getElementsByClassName("testo_pillola_libro")[0].childNodes[0];
        var w = pillola.offsetWidth-padding_testo[1]-padding_testo[3];
        var h = pillola.offsetHeight-padding_testo[0]-padding_testo[2];
        if(testo.offsetWidth > w || testo.offsetHeight>h){

            var n = w/h;
            var oh = testo.offsetHeight; //-padding_testo[0]-padding_testo[2];
            var ow = testo.offsetWidth; //-padding_testo[1]-padding_testo[3];
            var rh = ( (oh+ow)/(n+1) );
            var rw = n*rh;
            console.log(n, oh, ow, rh, rw);

            testo.style.width = (rw) + "px";

            var c = w / testo.offsetWidth;
            var d = h / testo.offsetHeight;
            if(d<c) c=d;
            testo.style.transform = "translate(-" + (100 - 100 * c) / 2 + "%, -"+ (100 - 100 * c) / 2 +"%) scale(" + c + ")";
        }
    }
}*/

var f_a = 23;
var f_t = 25;

function f(){
    for (var i = 0; i < pillola_libro.length; i++) {
        console.log("ciao2");
        var pillola = pillola_libro[i];
        var testo = pillola.getElementsByClassName("testo_pillola_libro")[0];
        var w = pillola.offsetWidth;
        var h = pillola.offsetHeight;
        var autore = testo.getElementsByTagName("div")[0];
        var titolo = testo.getElementsByTagName("div")[1];
        autore.style.fontSize = f_a+"px";
        titolo.style.fontSize = f_t+"px";
        if(testo.offsetWidth > w || testo.offsetHeight>h){
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
window.addEventListener('resize', function() {
    console.log("ciao");
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
        f();
    }, 250);
});


/*
|--------------------------------------------------------------|
|                                                              |
|  Chiamate ajax                                               |
|                                                              |
|--------------------------------------------------------------|
*/

function info_libro(id) {
    menu_info.style.transform = "translateX(-500px)";
    function cb (r) {
        menu_info.innerHTML = r.responseText;
    }
    chiama_get({id : id}, "/libri/php/infolibro.php", cb, menu_info, 120);
}

function modifica_libro(id_libro) {
    var edit = menu_info.getElementsByClassName("testo_scatola_info");
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
        input.value = edit[0].innerHTML;
        var val = edit[0].innerHTML;
        if (tt.innerText === "isbn" && edit[0].innerHTML === "non specificato") {
            input.value = "";
        }
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
            menu_info.querySelector('select[name=libreria]').onchange();
            input.value = parseInt(val);
        }
    }
    document.getElementById("salame3").style.display = "none";
    document.getElementById("salame2").style.display = "block";
    document.getElementById("salame").style.display = "block";
}

function azzera_menu_aggiungi() {
    finestra_scan.innerHTML = "";
    preview_img.style.backgroundImage = "url('/imgs/librosconosciuto.svg')";
    var inputs = menu_aggiungi.getElementsByTagName("input");
    for(var i = 0; i<inputs.length; i++){
        inputs[i].value = "";
    }
    menu_aggiungi.getElementsByTagName("textarea")[0].value = "";
    menu_aggiungi.querySelector("select[name=nome_libreria]").value = "nessuna";
    menu_aggiungi.querySelector("select[name=scaffale]").value = 0;
    generi.innerHTML = '<div class="pillola_genere" contenteditable="true"><img onclick="nuovo_genere(this)" src="../imgs/piu_pillola.svg"></div>';
    if(quagga_acceso) Quagga.stop();
}

function aggiorna_libro(id, el) {
    function cb(r) {
        console.log(r.responseText);
        info_libro(id);
        document.querySelector('.pillola_libro[onclick="info_libro(' + id + ')"]').innerHTML = r.responseText;
    }
    var scatole_generi = menu_info.querySelectorAll('.pillola_genere[contenteditable=false]');
    var gi = trova_generi(scatole_generi);
    console.log("."+gi+".");
    var a = {
        id : id,
        letto : menu_info.querySelector('input[name=inputLetto]').value,
        titolo : menu_info.querySelector('input[name=titolo]').value,
        autore : menu_info.querySelector('input[name=autore]').value,
        isbn : menu_info.querySelector('input[name=isbn]').value,
        descr : menu_info.querySelector('textarea[name=descrizione]').value,
        libreria : menu_info.querySelector('select[name=libreria]').value,
        scaffale : menu_info.querySelector('select[name=scaffale]').value,
        img_url : encodeURIComponent(menu_info.querySelector('input[name=img_url]').value),
        generi : gi
    };
    chiama_post(a,"/libri/php/aggiornalibro.php", cb, el, 40);
}

function nuovo_libro(el) {
    function cb(r) {
        chiama_menu_aggiungi();
        menu_aggiungi.innerHTML = r.responseText;
    }
    var scatole_generi = menu_aggiungi.querySelectorAll('.pillola_genere[contenteditable=false]');
    var generi = trova_generi(scatole_generi);
    var a  = {
        titolo : menu_aggiungi.querySelector('input[name=titolo]').value,
        autore : menu_aggiungi.querySelector('input[name=autore]').value,
        isbn : menu_aggiungi.querySelector('input[name=isbn]').value,
        descr : menu_aggiungi.querySelector('textarea[name=descr]').value,
        nome_libreria : menu_aggiungi.querySelector('select[name=nome_libreria]').value,
        scaffale : menu_aggiungi.querySelector('select[name=scaffale]').value,
        img_url : encodeURIComponent(menu_aggiungi.querySelector('input[name=img_url]').value),
        generi : generi
    };
    chiama_post(a,"/libri/php/nuovolibro.php", cb, el, 40);
}

function trova_generi(scatole_generi) {
    var generi = "";
    for(var i = 0; i<scatole_generi.length; i++){
        generi += scatole_generi[i].innerText;
        if(i!==scatole_generi.length-1) generi += ",";
    }
    return generi;
}



function ordina(el, ordina) {
    function cb(r) {
        pillole_libro.innerHTML = r.responseText;
        apri_menu_volante(el.parentElement.id.replace("menu_volante_",""));
    }
    chiama_post({ordina: ordina}, "/libri/php/ordina.php", cb, el, 35);
}

barra_ricerca.onkeyup = function (e) {
    if (e.keyCode == 13) {
        function cb(r) {
            pillole_libro.innerHTML = r.responseText;
        }
        chiama_get({ordina: barra_ricerca.value}, "/libri/php/cercalibro.php", cb, document.querySelector("div[onclick=\"chiama_barra_ricerca()\"]"), 50);
    }
};

function elimina_libro(id, el) {
    function cb(r) {
        chiudi_menu_info();
        menu_info.innerHTML = r.responseText;
        if (r.responseText === "libro eliminato") {
            var e = document.querySelector('.pillola_libro[onclick="info_libro(' + id + ')"]');
            e.parentNode.removeChild(e);
        }
    }
    chiama_post({id : id}, "/libri/php/eliminalibro.php", cb, el, 50);
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
    selectBox.onchange = function () { scaffali(this, menu_info.querySelector('select[name=scaffale]')); };
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

var finestra_scan = document.getElementById("finestra_scan");
var quagga_acceso = false;

function mostra_scanner() {
    if(quagga_acceso){
        quagga_acceso = false;
        finestra_scan.innerHTML = "";
        Quagga.stop();
        return;
    }
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
        quagga_acceso = true;
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
        if( lastResult.length === 13 && !lastResult.startsWith("978") && !lastResult.startsWith("979") ){
            finestra_scan.appendChild(avviso("Il codice scannerizzato non è un isbn"));
        }else{
            finestra_scan.innerHTML = "";
            Quagga.stop();
        }
        isbn.oninput();
    }
});

function avviso(testo){
    var div = document.createElement("DIV");
    div.className = "avviso";
    div.innerText = testo;
    return div;
}

isbn.onkeyup = function (e) {
    if (e.keyCode == 13) {
        isbn.oninput();
    }
};
