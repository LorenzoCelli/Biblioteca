var ris_cerca = document.getElementById("barra_ricerca");
var ris_div = document.getElementById("ris_div");
function ricerca_utenti() {
  if (ris_cerca.value == "") {
    return;
  }else{
    document.getElementById("search_button").style.borderBottomRightRadius = "0px";
    document.getElementById("barra_ricerca").style.borderBottomLeftRadius = "0px";
    function cb(r) {
      ris_div.innerHTML = r.responseText;
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
  var scheda_utente = button.parentElement;
  function cb(r) {
    scheda_utente.style.display = "none";
  }
  chiama_get({bool:bool,id_amico:id_amico},"php/accetta_rifiuta.php",cb);
}
function nascondi_notifiche() {
  document.getElementsByClassName("notifica")[0].style.display = "none";
}
function visita_profilo(id_profilo,uname_profilo) {
  window.location.href = "/profili/index.php?id_profilo="+id_profilo+"&uname_profilo="+uname_profilo;
}
function searchAnimation() {
  window.addEventListener('click', function(e){
    if (document.getElementById('barra_ricerca').contains(e.target) || document.getElementById('search_button').contains(e.target)){
      document.getElementById("barra_ricerca").style.transition = "all 0.4s ease"
      document.getElementById("barra_ricerca").style.paddingLeft = "10px";
    }
  });
}
//quando premi invio si apre il div con gli amici
var input = document.getElementById("barra_ricerca");
input.addEventListener("keyup", function(event) {
    event.preventDefault();
    if (event.keyCode === 13) {
        document.getElementById("search_button").click();
    }
});

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
    document.getElementsByClassName("title")[0].style.marginBottom = "10px";
    document.getElementsByClassName("title")[1].style.marginBottom = "10px";
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
function myFunction(x) {
    if (x.matches) {
      document.getElementsByClassName('scatola_amici')[0].style.display = "inline-block";
      document.getElementsByClassName('scatola_biblioteca')[0].style.display = "inline-block";
    }else {
      document.getElementsByClassName('scatola_biblioteca')[0].style.display = "none";
    }
}
var x = window.matchMedia("(min-width: 650px)");
myFunction(x);
x.addListener(myFunction);
