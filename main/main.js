var search_bar = document.getElementById("search_bar");
function slide_search_bar() {
    if(search_bar.style.width === "" || search_bar.style.width === "0px"){
        search_bar.style.width = "500px";
    }else{
        search_bar.style.width = "0px";
    }
}

var little_menu = document.getElementById("little_menu_box");
function show_little_menu() {
    if(little_menu.style.height === "" || little_menu.style.height === "0px"){
        little_menu.style.display = "block";
        little_menu.style.height = "auto";
    }else{
        little_menu.style.display = "none";
        little_menu.style.height = "0px";
    }
}
var menu_account = document.getElementById("menu_account");
function show_menu_account() {
    if(menu_account.style.display === "" || menu_account.style.display === "none"){
        menu_account.style.display = "block";
    }else{
        menu_account.style.display = "none";
    }
}
var new_menu = document.getElementById("new_menu");
function slide_new_menu(){
    if(!new_menu.is_open){
        close_info_menu();
        new_menu.style.transform = "translateX(-400px)";
        new_menu.is_open = true;
    }else{
        new_menu.style.transform = "translateX(0)";
        new_menu.is_open = false;
    }
}

var main_menu = document.getElementById("main_container");
function slide_main_menu(){
    if(!main_menu.is_open){
        main_menu.style.transform = "translateX(0)";
        main_menu.is_open = true;
    }else{
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

function listalibrerie() {
  var select = document.querySelector('select[name=nome_libreria]');
  var select2 = document.querySelector('select[name=scaffale]');
  var num_scaffali = libreria[select.value];
  select2.innerHTML = "";
  for (var i = 1; i <= num_scaffali; i++) {
    select2.innerHTML += "<option value='"+i+"'>"+i+"</option>";
  }
}


isbn.onblur = fill_isbn_data;
function fill_isbn_data() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var r = JSON.parse(this.response);
            console.log(r);
            if(r.totalItems !== 1) return;
            r = r.items[0].volumeInfo;
            titolo.value = r.title;
            var authors = "";
            for(var i=0;i<r.authors.length; i++){
                authors+=r.authors[i];
                if(i!==r.authors.length-1) authors+=", ";
            }
            autore.value = authors;
            descr.value = r.description;
            img.style.backgroundImage = "url('"+r.imageLinks.thumbnail+"')";
            img_url.value = r.imageLinks.thumbnail;
        }
    };
    console.log("https://www.googleapis.com/books/v1/volumes?q=isbn"+isbn.value);
    xhttp.open("GET", "https://www.googleapis.com/books/v1/volumes?q=isbn"+isbn.value, true);
    xhttp.send();
}

var info_menu = document.getElementById("info_menu");
function fill_info_book(id_libro){
    info_menu.innerHTML = '<img id="loading" src="../imgs/loading.svg" alt="loading.." width="120" height="120">';
    info_menu.style.transform = "translateX(-500px)";
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            info_menu.innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "infolibro.php"+"?id="+id_libro, true);
    xhttp.send(null);
}
function close_info_menu() {
    info_menu.style.transform = "translateX(0)"
}
function delete_book(id_libro, el) {
    el.innerHTML = '<img id="loading" style="box-sizing: border-box; height: 50px;width: 50px" src="../imgs/loading.svg" alt="loading..">';
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            close_info_menu();
            info_menu.innerHTML = this.responseText;
            if(this.responseText === "libro eliminato"){
                var e = document.querySelector('.book_container[onclick="fill_info_book('+id_libro+')"]');
                e.parentNode.removeChild(e);
            }
        }
    };
    xhttp.open("POST", "eliminalibro.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id="+id_libro);
}
