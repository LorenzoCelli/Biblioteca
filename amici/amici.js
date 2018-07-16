function ricerca_utenti() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            change_div.innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "cambioavatar.php" + "?id_avatar=" + big_icon.alt, true);
    xhttp.send(null);
}
