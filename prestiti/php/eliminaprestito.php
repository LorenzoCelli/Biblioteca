<?php

error_reporting(-1);
ini_set('display_errors', 'On');

session_start();
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';
$id_utente = $_SESSION['id_utente'];
$id_prestito = $_GET['id_prestito'];

$sql = "DELETE FROM prestiti WHERE id_prestito=$id_prestito AND id_creditore=$id_utente";
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

if ($result) {
  header('Location: /prestiti/');
  return;
}

mysqli_close($conn);

?>
