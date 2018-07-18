<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

$id_utente = $_SESSION['id_utente'];
$id_libro = $_POST["id"];
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

$sql = "SELECT * FROM libri WHERE id_utente = ".$id_utente." AND id = ".$id_libro;
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

if($result->num_rows == 0){
    return;
}

$sql = "DELETE FROM posizione WHERE id_libro = ".$id_libro;
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

if($result){
    $sql = "DELETE FROM generi WHERE id_libro = ".$id_libro;
    $result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));
    if($result){
        $sql = "DELETE FROM libri WHERE id = ".$id_libro;
        $result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));
        if($result){
            echo "libro eliminato";
        }
    }
}
mysqli_close($conn);