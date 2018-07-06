<?php
session_start();
ini_set('display_errors',1);
error_reporting(E_ALL);
$id_utente = $_SESSION['id_utente'];
echo $id_utente."  .";
include '../connection.php';

$isbn = $_POST["isbn"];
echo $isbn."  .";
$titolo = $_POST["titolo"];
echo $titolo."  .";
$autore = $_POST["autore"];
echo $autore."  .";
$descr = $_POST["descr"];
echo $descr."  .";
/*$nome = $_POST["nome_libreria"];
$scaffale = $_POST["scaffale"];*/

$sql = "INSERT INTO libri (isbn,id_utente,titolo,autore,descr)
VALUES ('$isbn','$id_utente','$titolo','$autore','$descr')";
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn)." ".$sql);
echo $result;
/*$id_libro = mysqli_query($conn, "SELECT * FROM libri")->num_rows;
echo $id_libro;
$libr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM libreria WHERE id_utente = '$id_utente' AND nome = '$nome'"));
$id_libreria = $libr['id'];
$sql = "INSERT INTO posizione
(id_libro,n_scaffale,id_libreria)
VALUES
('$id_libro','$scaffale','$id_libreria')";
$results = mysqli_query($conn, $sql);*/

if ($result/* && $results*/) echo "<script>window.open('main.php','_self');</script>";
else echo "qualcosa è andato storto col database";

mysqli_close($conn);

?>
