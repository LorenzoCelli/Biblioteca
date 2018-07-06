<?php
session_start();
ini_set('display_errors',1);
error_reporting(E_ALL);
$id_utente = 1;
include '../connection.php';

$isbn = 123123123;
$titolo = $_POST["titolo"];
$autore = "autoreeee";
$descr = "descr";
/*$nome = $_POST["nome_libreria"];
$scaffale = $_POST["scaffale"];*/

$sql = "INSERT INTO libri (isbn,id_utente,titolo,autore,descr)
VALUES ('$isbn','$id_utente','$titolo','$autore','$descr')";
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn)." ".$sql);
echo $result;

if ($result) echo "bravoooo".$titolo;
else echo "qualcosa è andato storto col database";

mysqli_close($conn);

?>