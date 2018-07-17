<?php
session_start();
include "../connection.php";
$id_utente = $_SESSION['id_utente'];
$ris_cerca = $_GET['ris_cerca'];
include 'scriptusericon.php';
$ricerca = "%";
for ($i=0; $i < strlen($ris_cerca); $i++) {
  $ricerca .= $ris_cerca{$i}."%";
}

$sql = "SELECT *
FROM utenti
WHERE MATCH (username)
AGAINST ('$ris_cerca' IN NATURAL LANGUAGE MODE WITH QUERY EXPANSION)
UNION
SELECT *
FROM utenti
WHERE username LIKE '$ricerca';";
$results = mysqli_query($conn, $sql);
if ($results->num_rows == 0) {
  echo "<p id='no_amici'>Nessun utente trovato!</p>";
}else{
  while ($row = mysqli_fetch_assoc($results)) {
    $uname_amico = $row['username'];
    $avatar_amico = $row['id_avatar'];
    $img_avatar = avatar($avatar_amico);
    echo "
    <div style='display:block;margin-right:10px;'>
    <a><button style='display:inline-block;width:50px;height:50px;'>+</button></a>
    <a><div><div style='cursor:pointer;display: inline-block; height: 50px; width: 50px; overflow: hidden'><img id='small_icon' src='$img_avatar' style='width:50px;height:50px;'></div>
    <p2 id='nome_utente'>$uname_amico</p2></div>
    </div></a>
    ";
  }
}

?>
