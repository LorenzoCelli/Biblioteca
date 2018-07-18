<?php
session_start();
include "../../connection.php";
$id_utente = $_SESSION['id_utente'];
$id_amico = $_GET['id_amico'];
$bool = $_GET['bool'];

if ($bool) {
  $sql = "UPDATE amici
  SET accettato = 1
  WHERE id_utente='$id_utente' AND id_amico='$id_amico' AND accettato=0";
  $results = mysqli_query($conn, $sql);
}else {
  $sql = "DELETE FROM amici WHERE id_utente='$id_utente' AND id_amico='$id_amico' AND accettato=0";
  $results = mysqli_query($conn, $sql);
}

?>
