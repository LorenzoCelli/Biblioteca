<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';
$id_utente = $_SESSION['id_utente'];
$id_amico = mysqli_real_escape_string($conn,$_GET['id_amico']);
$bool = mysqli_real_escape_string($conn,$_GET['bool']);

if ($bool == "1") {
  $sql = "UPDATE amici
  SET accettato = 1
  WHERE id_utente=$id_amico AND id_amico=$id_utente AND accettato=0";
  $results = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));
}elseif ($bool == "0") {
  $sql = "DELETE FROM amici WHERE id_utente=$id_amico AND id_amico=$id_utente AND accettato=0";
  $results = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));
}



?>
