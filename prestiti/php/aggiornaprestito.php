<?php

error_reporting(-1);
ini_set('display_errors', 'On');

session_start();
$id_utente = $_SESSION['id_utente'];
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

$id_prestito = mysqli_real_escape_string($conn,$_POST["id_prestito"]);
$titolo = mysqli_real_escape_string($conn,$_POST["titolo"]);
echo $titolo;
$sql = "SELECT id FROM libri WHERE titolo='$titolo' AND id_utente=$id_utente";
$row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
$id_libro = $row['id'];
$debitore = mysqli_real_escape_string($conn,$_POST["debitore"]);
echo $debitore;
$sql = "SELECT id FROM utenti WHERE username='$debitore'";
$row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
$id_debitore = $row['id'];
$data_inizio = mysqli_real_escape_string($conn,$_POST["data_inizio"]);
echo $data_inizio;
$data_promemoria = mysqli_real_escape_string($conn,$_POST["data_promemoria"]);
echo $data_promemoria;
$data_fine = mysqli_real_escape_string($conn,$_POST["data_fine"]);
if ($data_fine == "") {
  $data_fine = 'NULL';
}

$sql = "UPDATE prestiti
SET id_libro=$id_libro, id_debitore=$id_debitore, data_inizio='$data_inizio', data_promemoria='$data_promemoria', data_fine=$data_fine
WHERE id_creditore = $id_utente AND id_prestito = $id_prestito";
echo $sql;
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

mysqli_close($conn);

?>
