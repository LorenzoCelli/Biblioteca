<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

$id_utente = $_SESSION['id_utente'];
$id_amico = mysqli_real_escape_string($conn,$_GET['id_amico']);

$sql = "INSERT INTO amici (id_amico,accettato,id_utente) VALUES ('$id_amico',0,'$id_utente')";
$results = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

?>
