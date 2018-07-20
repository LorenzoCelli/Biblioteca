<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';
$id_utente = $_SESSION['id_utente'];
$id = mysqli_real_escape_string($conn,$_POST["id"]);
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
