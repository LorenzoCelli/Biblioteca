<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

include '../connection.php';

$id_utente = $_SESSION['id_utente'];
$id_libro = $_POST["id"];
$isbn = $_POST["isbn"];
$titolo = $_POST["titolo"];
$autore = $_POST["autore"];
$libreria = $_POST["libreria"];
$scaffale = $_POST["scaffale"];
$descr = mysqli_real_escape_string($conn,$_POST["descr"]);

$sql = "SELECT id FROM libreria WHERE id_utente = '$id_utente' AND nome = '$libreria'";
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

if($result && $result->num_rows == 1){
    $row = mysqli_fetch_assoc($result);
    $id_libreria = $row["id"];

    $sql = "UPDATE libri SET isbn= '".$isbn."', titolo= '".$titolo."', autore= '".$autore."', descr= '".$descr."' WHERE id = ".$id_libro;
    $result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

    if($result){
        $sql = "SELECT id_libro FROM posizione WHERE id_libro = ".$id_libro;
        $result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

        if($result && $result->num_rows == 1){
            $sql = "UPDATE posizione SET n_scaffale= ".$scaffale.", id_libreria= ".$id_libreria." WHERE id_libro = ".$id_libro;
            $result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

            if($result){
                echo "fatto";
            }
        }else{
            $sql = "INSERT INTO posizione (id_libro, n_scaffale, id_libreria) VALUES ($id_libro, $scaffale, $id_libreria)";
            $result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

            if($result){
                echo "fatto";
            }
        }

    }
}
