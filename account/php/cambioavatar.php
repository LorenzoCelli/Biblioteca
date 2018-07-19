<?php
session_start();
include "../../connection.php";
$id_utente = $_SESSION['id_utente'];
$id_avatar = $_GET['id_avatar'];

$sql = "UPDATE utenti SET id_avatar = '$id_avatar' WHERE id = '$id_utente'";
$results = mysqli_query($conn, $sql);

if ($results) {
  echo "Modiche avvenute con successo.";
}else {
  echo "Qualcosa è andato storto.";
}

?>
