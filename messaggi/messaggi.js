

var ris_div = document.getElementById("scatola_messaggi");

var sessione = {
    n_sessione: 0,
    init : function (id_amico, uname_amico) {
      this.n_sessione++;
      this.id_amico = id_amico;
      this.uname_amico = uname_amico;
      var cb = function(r) {
          ris_div.innerHTML = r.responseText;
          if(ris_div.childNodes.length) ris_div.childNodes[ris_div.childNodes.length-1].scrollIntoView(true);
          this.nuovi_messaggi();
      }.bind(this);
      document.getElementById("amico_msg").innerHTML = this.uname_amico;
      ris_div.innerHTML = "";
      chiama_get({id_amico:id_amico},"php/mostra_messaggi.php", cb);
    },
    num_msg : function () {
        return ris_div.querySelectorAll(".messaggio[style='text-align:left']").length;
    },
    nuovi_messaggi : function() {
        var i = this.n_sessione;
        var cb = function(r) {
            if (i !== this.n_sessione){
                return;
            }
            var div = document.createElement("div");
            div.innerHTML = r.responseText;
            while (div.childNodes.length > 0) {
                ris_div.appendChild(div.childNodes[0]);
            }
            div.scrollIntoView(true);
            this.nuovi_messaggi();
        }.bind(this);
        chiama_get({id_amico: this.id_amico, num_msg: this.num_msg()},"/messaggi/php/nuovi_messaggi.php",cb);
    },
    invia_messaggio: function() {
        var testo = document.getElementById("testo").value;
        var cb = function(r){
            var div = document.createElement("div");
            div.className = "messaggio";
            div.style.textAlign = "right";
            div.innerHTML = r.responseText;
            ris_div.appendChild(div);
            div.scrollIntoView(true);
        }.bind(this);
        chiama_get({testo:testo,id_amico:this.id_amico},"php/invia_messaggio.php",cb);
    }
};

var sessione_corrente = new Object(sessione);
sessione_corrente.init(1, "Denis");

function nuova_sessione(id_amico, uname_amico) {
    sessione_corrente.init(id_amico, uname_amico);
}
function invia_messaggio() {
    sessione_corrente.invia_messaggio();
}


