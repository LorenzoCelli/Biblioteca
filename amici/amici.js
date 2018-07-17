var ris_cerca = document.getElementById("search_bar");
var ris_div = document.getElementById("ris_div");
function ricerca_utenti() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            ris_div.innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "cerca.php" + "?ris_cerca=" + ris_cerca.value, true);
    xhttp.send(null);
}
