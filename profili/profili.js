function aggiungi_preferiti(id_profilo) {
  var stellina = document.getElementById("stellina");
  function a(){
    stati(stellina, function(){
      stellina.style.transform = "rotate(360deg)";
    },function(){
      stellina.style.transform = "rotate(0deg)";
    });
  }
  a();
  var caricamento = setInterval(function() {
    a();
  }, 500);
  function cb(r) {
    clearInterval(caricamento);
    stellina.src = r.responseText;
  }
  chiama_get({id_profilo:id_profilo},"php/aggiungi_preferiti.php",cb);
}
function info_libro_amico(id) {
    menu_info.style.transform = "translateX(-500px)";
    function cb (r) {
        menu_info.innerHTML = r.responseText;
    }
    chiama_get({id : id}, "/profili/php/infolibro.php", cb, menu_info, 120);
}
