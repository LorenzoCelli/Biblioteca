var ris_cerca = document.getElementById("search_bar");
var ris_div = document.getElementById("ris_div");
function ricerca_utenti() {
    ris_div.innerHTML = "";
    var img = caricamento_img(120);
    img.style.margin = "0";
    ris_div.appendChild(img);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            ris_div.innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "cerca.php" + "?ris_cerca=" + ris_cerca.value, true);
    xhttp.send(null);
}
function aggiungi_utenti(id_amico,button) {
    var risp_richiesta = button.parentElement.getElementsByClassName("risp_richiesta")[0];
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            button.disabled = "true";
            risp_richiesta.style.height = "30px";
            risp_richiesta.innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "aggiungi.php" + "?id_amico=" + id_amico, true);
    xhttp.send(null);
}
