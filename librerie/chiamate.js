var content = document.getElementsByClassName("content")[0];

function aggiorna_libreria(el, id) {
    function cb(r) {
            close_info_menu();
            var result = JSON.parse(r.responseText);
            if(result["success"]){
                content.querySelector('.book_container[onclick="info_libreria(' + id + ')"]').innerHTML = result["content"];
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
    document.getElementById("info_book_menu").appendChild(loading_img(120));
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
            var e = content.querySelector('.book_container[onclick="info_libreria(' + id + ')"]');
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
            content.insertBefore(div.getElementsByTagName("DIV")[0], content.getElementsByClassName("book_container")[0]);
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

