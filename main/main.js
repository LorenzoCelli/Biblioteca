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

var img = document.getElementById("new_menu_img");
var img_url = document.querySelector('input[name=img_url]');
var isbn = document.querySelector('input[name=isbn]');
var titolo = document.querySelector('input[name=titolo]');
var autore = document.querySelector('input[name=autore]');
var descr = document.querySelector('textarea[name=descr]');

isbn.onblur = fill_isbn_data;

function fill_isbn_data() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var r = JSON.parse(this.response);
            console.log(r);
            if (r.totalItems !== 1) return;
            r = r.items[0].volumeInfo;
            titolo.value = r.title;
            var authors = "";
            for (var i = 0; i < r.authors.length; i++) {
                authors += r.authors[i];
                if (i !== r.authors.length - 1) authors += ", ";
            }
            autore.value = authors;
            descr.value = r.description;
            img.style.backgroundImage = "url('" + r.imageLinks.thumbnail + "')";
            img_url.value = r.imageLinks.thumbnail;
        }
    };
    console.log("https://www.googleapis.com/books/v1/volumes?q=isbn" + isbn.value);
    xhttp.open("GET", "https://www.googleapis.com/books/v1/volumes?q=isbn" + isbn.value, true);
    xhttp.send();
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
    info_menu.style.transform = "translateX(0)"
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
    annulla.onclick = function () {fill_info_book(id_libro)};
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

    var a = "id="+id_libro+"&titolo="+titolo+"&autore="+autore+"&isbn="+isbn+"&descr="+descr+"&libreria="+libreria+"&scaffale="+scaffale+"&img_url="+encodeURIComponent(img_url);
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