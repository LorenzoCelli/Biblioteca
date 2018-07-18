<?php
session_start();
include "../connection.php";
$id_utente = $_SESSION['id_utente'];
$ris_cerca = $_GET['ris_cerca'];
include '../scriptusericon.php';
$ricerca = "%";
for ($i=0; $i < strlen($ris_cerca); $i++) {
  $ricerca .= $ris_cerca{$i}."%";
}

$sql = "SELECT * FROM utenti
WHERE MATCH (username) AGAINST ('$ris_cerca' IN NATURAL LANGUAGE MODE WITH QUERY EXPANSION)
UNION
SELECT * FROM utenti WHERE username LIKE '$ricerca'";
$results = mysqli_query($conn, $sql);
if ($results->num_rows == 0) {
  echo "<p id='no_amici'>Nessun utente trovato!</p>";
}else{
  while ($row = mysqli_fetch_assoc($results)) {
    $uname_amico = $row['username'];
    $avatar_amico = $row['id_avatar'];
    $id_amico = $row['id'];
    $img_avatar = avatar($avatar_amico);
    echo "
    <a><div id='scheda_utente'>
    <img src='$img_avatar' id='avatar_img'>
    <p2 id='nome_utente' style='display:inline-block;'>$uname_amico</p2><!--
    --><button id='friend_button' onclick='aggiungi_utenti($id_amico,this)'></button><!--
    --><div class='risp_richiesta'></div>
    </div></a>
    ";
  }
}

?>
