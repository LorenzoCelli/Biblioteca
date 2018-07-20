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
  function cb(r) {
    risultato_cambio_avatar.innerHTML = r.responseText;
    document.getElementById('small_icon').src = big_icon.src;
    avatars.style.display = "none";
  }
  chiama_get({id_avatar:big_icon.alt},"php/cambioavatar.php",cb);
}
