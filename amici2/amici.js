var ris_cerca = document.getElementById("search_bar");
var ris_div = document.getElementById("ris_div");
var contatoreMenu = 0;
function ricerca_utenti() {
  document.getElementById("search_button").style.borderBottomRightRadius = "0px";
  document.getElementById("search_bar").style.borderBottomLeftRadius = "0px";
  if (ris_cerca.value == "") {
    return;
  }else{
    function cb(r) {
      /*document.getElementById("ris_div").style.display = "block";*/
      ris_div.innerHTML = r.responseText;


      //chiude la tendina
      /*window.addEventListener('click', function(e){
        if (!document.getElementById('search_button').contains(e.target)){
          document.getElementById("ris_div").style.display = "none";
          document.getElementById("search_button").style.borderBottomRightRadius = "10px";
          document.getElementById("search_bar").style.borderBottomLeftRadius = "10px";
        }
      });*/
    }
    chiama_get({ris_cerca:ris_cerca.value},"php/cerca.php",cb,ris_div,120);
  }
}

function aggiungi_utenti(id_amico,button) {
  var loading_div = button.parentElement.getElementsByClassName("loading")[0];
  button.style.display = "none";
  function cb(r) {
    button.parentElement.getElementsByClassName("risp_richiesta")[0].style.display = "inline-block";
  }
  chiama_get({id_amico:id_amico},"php/aggiungi.php",cb,loading_div,40);
}
function accetta_rifiuta(id_amico,bool,button) {
  var scheda_utente = button.parentElement.parentElement.parentElement;
  function cb(r) {
    scheda_utente.style.display = "none";
  }
  var a = {bool:bool,id_amico:id_amico}
  chiama_get(a,"php/accetta_rifiuta.php",cb);
}
function searchAnimation() {
  window.addEventListener('click', function(e){
    if (document.getElementById('search_bar').contains(e.target) || document.getElementById('search_button').contains(e.target)){
      document.getElementById("search_bar").style.transition = "all 0.4s ease"
      document.getElementById("search_bar").style.paddingLeft = "10px";
    }
  });
}
function dropDown() {
  if(contatoreMenu%2 == 0) {
    document.getElementsByClassName("menu_amici_img")[0].style.transform = "rotate(0deg)";
    document.getElementsByClassName("menu_amici_img")[0].style.transition = "all 0.4s";
    document.getElementsByClassName("title")[0].style.marginBottom = "120px";
    document.getElementsByClassName("title")[0].style.transition = "all 0.4s";
    document.getElementsByClassName("title")[1].style.marginBottom = "120px";
    document.getElementsByClassName("title")[1].style.transition = "all 0.4s";
    document.getElementsByClassName("menu_amici")[0].style.height = "85px";
    document.getElementsByClassName("menu_amici")[0].style.transition = "all 0.4s";
    contatoreMenu++;
  } else {
    document.getElementsByClassName("menu_amici_img")[0].style.transform = "rotate(90deg)";
    document.getElementsByClassName("menu_amici_img")[0].style.transition = "all 0.4s";
    document.getElementsByClassName("title")[0].style.marginBottom = "10px";
    document.getElementsByClassName("title")[1].style.marginBottom = "10px";
    document.getElementsByClassName("menu_amici")[0].style.height = "0px";
    contatoreMenu--;
  }
}
function menuScelto(opzione,nascondi) {
  document.getElementsByClassName(nascondi)[0].style.display = "none";
    document.getElementsByClassName(opzione)[0].style.display = "block";
}
