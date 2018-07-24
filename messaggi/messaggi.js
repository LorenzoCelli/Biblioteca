var ris_div = document.getElementById("scatola_messaggi");
var amico_id = 5;
function mostra_messaggi(id_amico,uname_amico) {
  amico_id = id_amico;
  function cb(r) {
    document.getElementById("amico_msg").innerHTML = uname_amico;
    ris_div.innerHTML = r.responseText;
  }
  chiama_get({id_amico:id_amico},"php/mostra_messaggi.php",cb,ris_div,400);
}
function invia_messaggio(id_amico) {
  var testo = document.getElementById("testo").value;
  function cb(r) {
    var div = document.createElement("div");
    div.className = "messaggio";
    div.style.textAlign = "right";
    div.innerHTML = r.responseText;
    ris_div.appendChild(div);
  }
  chiama_get({testo:testo,id_amico:amico_id},"php/invia_messaggio.php",cb);
}
function num_msg() {
  return document.querySelectorAll(".messaggio[style='text-align:left']").length;
}
function nuovi_messaggi() {
  function cb(r) {
    var div = document.createElement("div");
    div.innerHTML = r.responseText;
    while (div.childNodes.length > 0) {
      ris_div.appendChild(div.childNodes[0]);
    }
    nuovi_messaggi();
  }
  chiama_get({id_amico:amico_id,num_msg:num_msg()},"php/nuovi_messaggi.php",cb);
}

nuovi_messaggi();
