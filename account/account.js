var avatars = document.getElementById("avatars");
var avatar_button = document.getElementById("avatar_button");
function show_avatars() {
    if (avatars.style.display === "" || avatars.style.display === "none") {
        avatars.style.display = "block";
        avatar_button.style.display = "none";
    } else {
        avatars.style.display = "none";
        avatar_button.style.display = "inline-block";
    }
}

var big_icon = document.getElementById("big_icon");
function change_avatar(elem) {
  big_icon.src = elem.src;
  big_icon.alt = elem.alt;
}
var change_div = document.getElementById("change_div");
function update_avatar() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            change_div.innerHTML = this.responseText;
            document.getElementById('small_icon').src = big_icon.src;
        }
    };
    xhttp.open("GET", "cambioavatar.php" + "?id_avatar=" + big_icon.alt, true);
    xhttp.send(null);
}
