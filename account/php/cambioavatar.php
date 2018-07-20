<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';
$id_utente = $_SESSION['id_utente'];
$id_avatar = mysqli_real_escape_string($conn,$_GET['id_avatar']);

$sql = "UPDATE utenti SET id_avatar = '$id_avatar' WHERE id = '$id_utente'";
$results = mysqli_query($conn, $sql);

if ($results) {
  echo "Modiche avvenute con successo.";
}else {
  echo "Qualcosa è andato storto.";
}

?>
