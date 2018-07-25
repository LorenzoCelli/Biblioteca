<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';
$id_utente = $_SESSION['id_utente'];
$ris_cerca = mysqli_real_escape_string($conn,$_GET['ris_cerca']);
$ricerca = "%";
for ($i=0; $i < strlen($ris_cerca); $i++) {
  $ricerca .= $ris_cerca{$i}."%";
}

$sql = "SELECT * from utenti
LEFT JOIN amici ON (amici.id_utente = $id_utente AND amici.id_amico = utenti.id)
OR (amici.id_utente = utenti.id AND amici.id_amico = $id_utente)
WHERE utenti.username LIKE '$ricerca' AND utenti.id != $id_utente";
$results = mysqli_query($conn, $sql);
if ($results->num_rows == 0) {
  echo "<p id='no_amici'>Nessun utente trovato!</p>";
}else{
  while ($row = mysqli_fetch_assoc($results)) {
    $id_amico = $row['id'];
    $uname_amico = $row['username'];
    $avatar_amico = $row['id_avatar'];
    $img_avatar = avatar($avatar_amico);
    if (is_null($row['id_amico'])) {
      echo "
      <div class='scheda_utente2'>
        <img src='$img_avatar'>
        <p style='display:inline-block;'>$uname_amico</p><!--
        --><div class='loading' style='display:inline-block;float:right;background-color:none;'></div><img src='/imgs/check.svg' style='display:none;' class='risp_richiesta'><!--
        --><button id='friend_button' onclick='aggiungi_utenti($id_amico,this)'></button>
      </div>
      ";
    }else{
      if ($row['accettato'] == 1) {
        $p = "Già amici";
      }elseif ($row['accettato'] == 0){
        if ($row['id_amico'] == $id_utente) {
          $p = "Già inviata";
        }else {
          $p = "Richiesta ricevuta";
        }

      }
      echo "
      <div class='scheda_utente2'>
        <img src='$img_avatar'>
        <p style='display:inline-block;'>$uname_amico</p><!--
        --><p style='display:inline-block;float:right'>$p</p>
      </div>
      ";
    }
  }
}

?>
