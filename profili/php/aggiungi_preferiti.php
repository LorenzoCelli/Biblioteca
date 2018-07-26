<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

$id_utente = $_SESSION['id_utente'];
$id_profilo = mysqli_real_escape_string($conn,$_GET['id_profilo']);

$sql = "SELECT * FROM preferiti WHERE id_utente=$id_utente AND id_biblioteca=$id_profilo";
$results = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

if ($results->num_rows >= 1) {
  $sql = "DELETE FROM preferiti WHERE id_utente=$id_utente AND id_biblioteca=$id_profilo";
  $results = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));
  echo "/imgs/stellaoff.png";
}elseif ($results->num_rows == 0){
  $sql = "INSERT INTO preferiti (id_utente,id_biblioteca) VALUES ($id_utente,$id_profilo)";
  $results = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));
  echo "/imgs/stellaon.png";
}


?>
