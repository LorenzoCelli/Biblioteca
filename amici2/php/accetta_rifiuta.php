<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';
$id_utente = $_SESSION['id_utente'];
$id_amico = mysqli_real_escape_string($conn,$_GET['id_amico']);
$bool = mysqli_real_escape_string($conn,$_GET['bool']);

if ($bool == 1) {
  $sql = "UPDATE amici
  SET accettato = 1
  WHERE id_utente='$id_utente' AND id_amico='$id_amico' AND accettato=0";
  $results = mysqli_query($conn, $sql);
}elseif ($bool == 0) {
  $sql = "DELETE FROM amici WHERE id_utente='$id_utente' AND id_amico='$id_amico'";
  $results = mysqli_query($conn, $sql);
}

?>
