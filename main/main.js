var search_bar = document.getElementById("search_bar");

function slide_search_bar() {
    if (search_bar.style.width === "" || search_bar.style.width === "0px") {
        search_bar.style.width = "500px";
    } else {
        search_bar.style.width = "0px";
    }
}

var little_menu = document.getElementById("little_menu_box");

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

var new_menu = document.getElementById("new_menu");

function slide_new_menu() {
    if (!new_menu.is_open) {
        close_info_menu();
        new_menu.style.transform = "translateX(-400px)";
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

var preview_img = document.getElementById("new_menu_img");
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
        generi.innerHTML = '<div class="genere_box" contenteditable="true"><img onclick="nuovo_genere(this)" src="../imgs/piu_pillola.svg"></div>';
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

function isbn_menu_option(titolo, autore, volumeInfo,l){ // <div class="isbn_menu_option"><b>Giovanninoioino</b> autore tuo padre</div>
    var div = document.createElement("DIV");
    div.className = "isbn_menu_option";
    if(l){
        div.appendChild(loading_img(40));
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

var info_menu = document.getElementById("info_menu");

function fill_info_book(id_libro) {
    info_menu.innerHTML = "";
    info_menu.appendChild(loading_img(120));
    info_menu.style.transform = "translateX(-500px)";
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            info_menu.innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "infolibro.php" + "?id=" + id_libro, true);
    xhttp.send(null);
}

function close_info_menu() {
    info_menu.style.transform = "translateX(0)";
}

function edit_book(id_libro) {
    var edit = info_menu.getElementsByClassName("info_p");
    while (edit.length) {
        var input = document.createElement("INPUT");
        var tt = edit[0].parentElement.getElementsByClassName("info_tooltip")[0];
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
            div.innerHTML = '<div class="genere_box" contenteditable="true"><img onclick="nuovo_genere(this)" src="../imgs/piu_pillola.svg"></div>';
            gi = edit[0].innerHTML.split(",");
            for (var i = 0; i<gi.length; i++){
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
    salva.onclick = function () { update_book(id_libro, this) };
    info_menu.appendChild(salva);
    var annulla = document.createElement("BUTTON");
    annulla.innerText = "annulla modifiche";
    annulla.onclick = function () { fill_info_book(id_libro) };
    info_menu.appendChild(annulla);
}

function update_book(id_libro, el) {
    el.innerHTML = "";
    el.appendChild(loading_img(40));
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            fill_info_book(id_libro);
            document.querySelector('.book_container[onclick="fill_info_book(' + id_libro + ')"]').innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "aggiornalibro.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    var titolo = info_menu.querySelector('input[name=titolo]').value;
    var autore = info_menu.querySelector('input[name=autore]').value;
    var isbn = info_menu.querySelector('input[name=isbn]').value;
    var descr = info_menu.querySelector('textarea[name=descrizione]').value;
    var libreria = info_menu.querySelector('select[name=libreria]').value;
    var scaffale = info_menu.querySelector('select[name=scaffale]').value;
    var img_url = info_menu.querySelector('input[name=img_url]').value;

    var generi_el = info_menu.querySelectorAll('.genere_box[contenteditable=false]');
    var gi = "";
    for(var i = 0; i<generi_el.length; i++){
        gi += generi_el[i].innerText;
        if(i!==generi_el.length-1) gi += ",";
    }

    var a = "id="+id_libro+"&generi="+gi+"&titolo="+titolo+"&autore="+autore+"&isbn="+isbn+"&descr="+descr+"&libreria="+libreria+"&scaffale="+scaffale+"&img_url="+encodeURIComponent(img_url);
    xhttp.send(a);
}

function new_book(el) {
    el.innerHTML = "";
    el.appendChild(loading_img(40));
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            new_menu.innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "nuovolibro.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    var titolo = new_menu.querySelector('input[name=titolo]').value;
    var autore = new_menu.querySelector('input[name=autore]').value;
    var isbn = new_menu.querySelector('input[name=isbn]').value;
    var descr = new_menu.querySelector('textarea[name=descr]').value;
    var libreria = new_menu.querySelector('select[name=nome_libreria]').value;
    var scaffale = new_menu.querySelector('select[name=scaffale]').value;
    var img_url = new_menu.querySelector('input[name=img_url]').value;

    var generi_el = new_menu.querySelectorAll('.genere_box[contenteditable=false]');
    var generi = "";
    for(var i = 0; i<generi_el.length; i++){
        generi += generi_el[i].innerText;
        if(i!==generi_el.length-1) generi += ",";
    }
    var a = "titolo="+titolo+"&autore="+autore+"&generi="+generi+"&isbn="+isbn+"&descr="+descr+"&nome_libreria="+libreria+"&scaffale="+scaffale+"&img_url="+encodeURIComponent(img_url);
    xhttp.send(a);
}

function delete_book(id_libro, el) {
    el.innerHTML = "";
    el.appendChild(loading_img(50));
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            close_info_menu();
            info_menu.innerHTML = this.responseText;
            if (this.responseText === "libro eliminato") {
                var e = document.querySelector('.book_container[onclick="fill_info_book(' + id_libro + ')"]');
                e.parentNode.removeChild(e);
            }
        }
    };
    xhttp.open("POST", "eliminalibro.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id=" + id_libro);
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

var l_img = document.createElement("IMG");
l_img.id = "loading";
l_img.src = "../imgs/loading.svg";

function loading_img(l) {
    l_img.alt = "loading..";
    l_img.style.width = l+"px";
    l_img.style.height = l+"px";
    return l_img;
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
    div.className = "genere_box";
    var img = document.createElement("IMG");
    img.src = "../imgs/piu_pillola.svg";
    div.add_img = img;
    div.append(img);
    return div;
}