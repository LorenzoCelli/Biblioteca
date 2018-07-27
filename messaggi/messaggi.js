var ris_div = document.getElementById("scatola_messaggi");
var textarea_invia = document.getElementById("testo");

var sessione = {
    n_sessione: 0,
    init : function (id_amico, uname_amico, el) {
      if(this.el) this.el.style.backgroundColor = "rgba(255,255,255,0.13)";
      this.el = el;
      el.style.backgroundColor = "rgba(255,255,255,0.2)";
      this.n_sessione++;
      var i = this.n_sessione;
      this.id_amico = id_amico;
      this.uname_amico = uname_amico;
      var cb = function(r) {
          if (i !== this.n_sessione) return;
          ris_div.innerHTML = r.responseText;
          if(ris_div.childNodes.length) ris_div.childNodes[ris_div.childNodes.length-1].scrollIntoView(true);
          this.nuovi_messaggi();
      }.bind(this);
      document.getElementById("amico_msg").innerHTML = this.uname_amico;
      ris_div.innerHTML = "";
      chiama_get({id_amico:id_amico},"php/mostra_messaggi.php", cb, el.getElementsByTagName("div")[0], 50);
    },
    num_msg : function () {
        return ris_div.querySelectorAll(".messaggio[style='text-align:left']").length;
    },
    nuovi_messaggi : function() {
        var i = this.n_sessione;
        var cb = function(r) {
            if (i !== this.n_sessione) return;
            var div = document.createElement("div");
            div.innerHTML = r.responseText;
            while (div.childNodes.length > 0) {
                ris_div.appendChild(div.childNodes[0]);
            }
            if(div.childNodes.length) div.childNodes[div.childNodes.length-1].scrollIntoView(true);
            this.nuovi_messaggi();
        }.bind(this);
        chiama_get({id_amico: this.id_amico, num_msg: this.num_msg()},"/messaggi/php/nuovi_messaggi.php",cb);
    },
    invia_messaggio: function(el) {
        var i = this.n_sessione;
        var testo = textarea_invia.value;
        textarea_invia.value = "";
        var cb = function(r){
            if (i !== this.n_sessione) return;
            var div = document.createElement("div");
            div.className = "messaggio";
            div.style.textAlign = "right";
            div.innerHTML = r.responseText;
            ris_div.appendChild(div);
            div.scrollIntoView(true);
        }.bind(this);
        chiama_get({testo:testo,id_amico:this.id_amico},"php/invia_messaggio.php",cb, el, 40);
    }
};

var sessione_corrente = new Object(sessione);

function nuova_sessione(id_amico, uname_amico, el) {
    sessione_corrente.init(id_amico, uname_amico, el);
}
function invia_messaggio(el) {
    sessione_corrente.invia_messaggio(el);
}

if(typeof primo_id !== "undefined"){
    nuova_sessione(primo_id[0], primo_id[1], document.querySelector(".contatti"));
}

