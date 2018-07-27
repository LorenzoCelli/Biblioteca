var avatars = document.getElementById("avatars");
function mostra_avatars() {
  if (avatars.style.width === "" || avatars.style.width === "0px") {
    avatars.style.width = "100%";
    avatars.style.height = "270px";
  } else {
    avatars.style.width = "0px";
    avatars.style.height = "0px";
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
    risultato_cambio_avatar.style.transition = "0.2s all";
    risultato_cambio_avatar.style.height = "30px";
    setTimeout(function() {
      risultato_cambio_avatar.style.height = "0px";
    },2000);
    if(r.responseText == "Qualcosa è andato storto.") {
      risultato_cambio_avatar.style.backgroundColor = "Tomato";
    }
    risultato_cambio_avatar.innerHTML = r.responseText;
    document.getElementById('small_icon').src = big_icon.src;
    avatars.style.width = "0px";
  }
  chiama_get({id_avatar:big_icon.alt},"php/cambioavatar.php",cb);
}
function animazionePulsanti(pulsante,altezza) {
  var pulsante = pulsante.parentElement.getElementsByTagName("div")[0];
  stati(pulsante,function(){
    pulsante.style.height = altezza + "px";
  },function(){
    pulsante.style.height = 0 + "px";
  })
}
