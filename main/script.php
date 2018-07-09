<?php

error_reporting(-1);
ini_set('display_errors', 'On');

session_start();
$id_utente = $_SESSION['id_utente'];
include '../connection.php';

$isbn = $_POST["isbn"];
$titolo = mysqli_real_escape_string($conn, $_POST["titolo"]);
$autore = mysqli_real_escape_string($conn,$_POST["autore"]);
$descr = mysqli_real_escape_string($conn,$_POST["descr"]);
$img_url = mysqli_real_escape_string($conn,$_POST["img_url"]);
$nome = mysqli_real_escape_string($conn,$_POST["nome_libreria"]);
$scaffale = mysqli_real_escape_string($conn,$_POST["scaffale"]);

echo $isbn."<br>".$titolo."<br>".$autore."<br>".$descr."<br>".$img_url."<br>";


$sql = "INSERT INTO libri (isbn,id_utente,titolo,autore,descr,img_url)
VALUES ('$isbn','$id_utente','$titolo','$autore','$descr','$img_url')";
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));;
/*$id_libro = mysqli_query($conn, "SELECT * FROM libri")->num_rows;
$libr = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM libreria WHERE id_utente = '$id_utente' AND nome = '$nome'"));
$id_libreria = $libr['id'];
$sql = "INSERT INTO posizione
(id_libro,n_scaffale,id_libreria)
VALUES
('$id_libro','$scaffale','$id_libreria')";
$results = mysqli_query($conn, $sql);
*/
if($result) echo "primo ok";

if ($result) echo "<script>window.open('main.php','_self');</script>";
else echo "qualcosa è andato storto col database";

mysqli_close($conn);

?>
