<?php
session_start();
$id_utente = $_SESSION['id_utente'];
include '../connection.php';

$nome = $_POST["nome"];
$descr = $_POST["descr"];
$scaffali = $_POST["n_scaffali"];

$sql = "INSERT INTO librerie (id_utente,nome,descr,n_scaffali)
VALUES ('$id_utente','$nome','$descr','$scaffali')";
$result = mysqli_query($conn, $sql);

if ($result) echo "<script>window.open('main.php','_self');</script>";
else echo "qualcosa è andato storto col database";

mysqli_close($conn);

?>
