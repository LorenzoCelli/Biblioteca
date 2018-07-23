<?php

error_reporting(-1);
ini_set('display_errors', 'On');

session_start();
$id_utente = $_SESSION['id_utente'];
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

$titolo = mysqli_real_escape_string($conn,$_POST["titolo"]);
$sql = "SELECT id FROM libri WHERE id_utente='$id_utente' AND titolo='$titolo'";
$row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
$libro = $row['id'];

$debitore = mysqli_real_escape_string($conn, $_POST["debitore"]);
$sql = "SELECT id FROM utenti WHERE username='$debitore'";
$row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
$id_debitore = $row['id'];

$data_inizio = mysqli_real_escape_string($conn,$_POST["data_inizio"]);
$data_promemoria = mysqli_real_escape_string($conn,$_POST["data_promemoria"]);

$sql = "INSERT INTO prestiti (id_libro,id_creditore,id_debitore,data_inizio,data_promemoria)
VALUES ('$libro','$id_utente','$id_debitore','$data_inizio','$data_promemoria')";
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

if ($result) {
  header('Location: /prestiti/');
  return;
}

mysqli_close($conn);

?>
