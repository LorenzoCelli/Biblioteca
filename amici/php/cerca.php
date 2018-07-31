<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';
$id_utente = $_SESSION['id_utente'];
$ris_cerca = mysqli_real_escape_string($conn,$_GET['ris_cerca']);
$ricerca = "%";
for ($i=0; $i < strlen($ris_cerca); $i++) {
  $ricerca .= $ris_cerca{$i}."%";
}

$sql = "SELECT utenti.id id_utente_amico,username,email,id_avatar,id_amico,accettato,id_utente FROM utenti
LEFT JOIN amici ON (amici.id_utente = $id_utente AND amici.id_amico = utenti.id)
OR (amici.id_utente = utenti.id AND amici.id_amico = $id_utente)
WHERE utenti.username LIKE '$ricerca' AND utenti.id != $id_utente";
$results = mysqli_query($conn, $sql);
if ($results->num_rows == 0) {
  echo "<p id='no_amici'>Nessun utente trovato!</p>";
}else{
  while ($row = mysqli_fetch_assoc($results)) {
    $id_amico = $row['id_utente_amico'];
    $uname_amico = $row['username'];
    $avatar_amico = $row['id_avatar'];
    $img_avatar = avatar($avatar_amico);
    if (is_null($row['id_amico'])) {
      echo "
      <div class='scheda_utente2'>
        <img src='$img_avatar'>
        <a onclick='visita_profilo($id_amico,\"$uname_amico\")' style='display:inline-block;margin: 0;vertical-align: top;padding: 0px 4px;line-height: 40px;'>$uname_amico</a><!--
        --><div class='loading' style='display:inline-block;float:right;background-color:none;'></div><img src='/imgs/check.svg' style='display:none;' class='risp_richiesta'><!--
        --><button id='friend_button' onclick='aggiungi_utenti($id_amico,this)'></button>
      </div>
      ";
    }else{
      if ($row['accettato'] == 1) {
        $p = "Già amici";
      }elseif ($row['accettato'] == 0){
        if ($row['id_amico'] == $id_utente) {
          $p = "Richiesta ricevuta";
        }else {
          $p = "Richiesta inviata";
        }
      }
      echo "
      <div class='scheda_utente2' onclick='visita_profilo($id_amico,\"$uname_amico\")'>
        <img src='$img_avatar'>
        <a onclick='visita_profilo($id_amico,\"$uname_amico\")' style='display:inline-block;margin: 0;vertical-align: top;padding: 0px 4px;line-height: 40px;'>$uname_amico</a><!--
        --><p id='risposta'>$p</p>
      </div>
      ";
    }
  }
}

?>
