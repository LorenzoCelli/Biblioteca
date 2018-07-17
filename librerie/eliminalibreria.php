<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

$id_utente = $_SESSION['id_utente'];
$id = $_POST["id"];
include '../connection.php';

$sql = "DELETE FROM libreria WHERE id = $id AND id_utente = $id_utente";
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

if(!$result){
    return;
}

$sql = "DELETE FROM posizione WHERE id_libreria = ".$id;
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

if($result){
    if($result){
        echo "libreria eliminata";
    }
}

mysqli_close($conn);