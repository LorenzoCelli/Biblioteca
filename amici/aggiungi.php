<?php
session_start();
include "../connection.php";
$id_utente = $_SESSION['id_utente'];
$id_amico = $_GET['id_amico'];

$sql = "INSERT INTO amici (id_utente,id_amico,accettato) VALUES ('$id_utente','$id_amico',0)";
$results = mysqli_query($conn, $sql);

if ($results) {
  echo "<b style='color:green;'>Richiesta inviata!</b>";
}else {
  echo "<b style='color:green;'>Qualcosa è andato storto!</b>";
}

?>
