<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');
$id_utente = $_SESSION['id_utente'];
$id = $_POST["id"];
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';
$sql = "SELECT * FROM libreria WHERE id_utente = ".$id_utente." AND id = ".$id;
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));
if($result->num_rows == 0 || !$result){
    return;
}
$sql = "DELETE FROM posizione WHERE id_libreria = ".$id;
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));
if($result){
    $sql = "DELETE FROM libreria WHERE id = $id AND id_utente = $id_utente";
    $result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));
    if($result){
        echo "libreria eliminata";
        return;
    }
}
mysqli_close($conn);