var ris_cerca = document.getElementById("search_bar");
var ris_div = document.getElementById("ris_div");
function ricerca_utenti() {
    /*if (ris_cerca.value == "") {
      return;
    }else{*/
    function cb(r) {
      ris_div.innerHTML = r.responseText;
    }
    chiama_get({ris_cerca:ris_cerca.value},"php/cerca.php",cb,ris_div,120);
    //}
}
/*function aggiungi_utenti(id_amico,button) {
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
}*/
function aggiungi_utenti(id_amico,button) {
    var risp_richiesta = button.parentElement.getElementsByClassName("risp_richiesta")[0];
    function cb(r) {
      button.disabled = "true";
      risp_richiesta.style.height = "30px";
      risp_richiesta.innerHTML = r.responseText;
    }
    chiama_get({id_amico:id_amico},"php/aggiungi.php",cb);
}
function accetta_rifiuta(id_amico,bool,button) {
    var scheda_utente = button.parentElement.getElementsByClassName("scheda_utente")[0];
    function cb(r) {
      scheda_utente.style.display = "none";
    }
    var a = {bool:bool,id_amico:id_amico}
    chiama_get(a,"php/accetta_rifiuta.php",cb);
}
