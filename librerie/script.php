<?php
session_start();
$id_utente = $_SESSION['id_utente'];
include '../connection.php';

$nome = $_POST["nome"];
$descr = $_POST["descr"];
$scaffali = $_POST["n_scaffali"];
$colore = $_POST["colore"];

$sql = "INSERT INTO libreria (id_utente,nome,descr,n_scaffali,colore)
VALUES ('$id_utente','$nome','$descr','$scaffali','$colore')";
$result = mysqli_query($conn, $sql);

if ($result) header('Location: librerie.php');//echo "<script>window.open('librerie.php','_self');</script>";
else echo "qualcosa è andato storto col database";

mysqli_close($conn);

?>
