var menu_info = document.getElementById("menu_info");
function info_tuoprestito(id_prestito) {
  menu_info.style.transform = "translateX(-500px)";
  function cb(r) {
    menu_info.innerHTML = r.responseText;
  }
  chiama_get({id_prestito:id_prestito},"php/infotuoprestito.php",cb,menu_info,120);
}
function info_prestito(id_prestito) {
  menu_info.style.transform = "translateX(-500px)";
  function cb(r) {
    menu_info.innerHTML = r.responseText;
  }
  chiama_get({id_prestito:id_prestito},"php/infoprestito.php",cb,menu_info,120);
}
function input_prestito() {
  var listainput = document.getElementsByClassName("input");
  var listainfo = menu_info.getElementsByClassName("info");
  for (var i = 0; i < listainput.length; i++) {
    listainput[i].style.display = "block";
  }
  for (var i = 0; i < listainfo.length; i++) {
    listainfo[i].style.display = "none";
  }
}
function elimina_prestito(id_prestito) {
  function cb(r) {
    menu_info.style.transform = "translateX(0)";
  }
  chiama_get({id_prestito:id_prestito},"php/eliminaprestito.php",cb,menu_info,120);
}
function aggiorna_prestito(id_prestito) {
    function cb(r) {
        //console.log(r.responseText);
    }
    var a = {
        id_prestito : id_prestito,
        titolo : menu_info.querySelector('input[name=titolo]').value,
        debitore : menu_info.querySelector('input[name=debitore]').value,
        data_inizio : menu_info.querySelector('input[name=data_inizio]').value,
        data_promemoria : menu_info.querySelector('input[name=data_promemoria]').value,
        data_fine : menu_info.querySelector('input[name=data_fine]').value
    };
    chiama_post(a,"/prestiti/php/aggiornaprestito.php", cb);
}
var amici = document.getElementsByClassName("menu_amici")[0];
function dropDown() {
  if(amici.style.height == "0px" || amici.style.height == "") {
    document.getElementsByClassName("menu_amici_img")[0].style.transform = "rotate(0deg)";
    document.getElementsByClassName("menu_amici_img")[0].style.transition = "all 0.4s";
    document.getElementsByClassName("title")[0].style.marginBottom = "120px";
    document.getElementsByClassName("title")[0].style.transition = "all 0.4s";
    document.getElementsByClassName("title")[1].style.marginBottom = "120px";
    document.getElementsByClassName("title")[1].style.transition = "all 0.4s";
    amici.style.height = "85px";
    amici.style.transition = "all 0.4s";
  } else {
    document.getElementsByClassName("menu_amici_img")[0].style.transform = "rotate(90deg)";
    document.getElementsByClassName("menu_amici_img")[0].style.transition = "all 0.4s";
    document.getElementsByClassName("title")[0].style.marginBottom = "0px";
    document.getElementsByClassName("title")[1].style.marginBottom = "0px";
    amici.style.height = "0px";
  }
}
function menuScelto(opzione,nascondi) {
  amici.style.height = "0px";
  document.getElementsByClassName("menu_amici_img")[0].style.transform = "rotate(90deg)";
  document.getElementsByClassName("menu_amici_img")[0].style.transition = "all 0.4s";
  document.getElementsByClassName("title")[0].style.marginBottom = "10px";
  document.getElementsByClassName("title")[1].style.marginBottom = "10px";
  document.getElementsByClassName(nascondi)[0].style.display = "none";
  document.getElementsByClassName(opzione)[0].style.display = "block";
}
