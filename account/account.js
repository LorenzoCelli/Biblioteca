var avatars = document.getElementById("avatars");
function mostra_avatars() {
    if (avatars.style.display === "" || avatars.style.display === "none") {
        avatars.style.display = "block";
    } else {
        avatars.style.display = "none";
    }
}

var big_icon = document.getElementById("big_icon");
function change_avatar(elem) {
  big_icon.src = elem.src;
  big_icon.alt = elem.alt;
}
var risultato_cambio_avatar = document.getElementById("risultato_cambio_avatar");
function update_avatar() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            risultato_cambio_avatar.innerHTML = this.responseText;
            document.getElementById('small_icon').src = big_icon.src;
            avatars.style.display = "none";
        }
    };
    xhttp.open("GET", "php/cambioavatar.php" + "?id_avatar=" + big_icon.alt, true);
    xhttp.send(null);
}
