<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

$id_utente = $_SESSION['id_utente'];
$id = mysqli_real_escape_string($conn, $_POST["id"]);
$titolo = mysqli_real_escape_string($conn, $_POST["titolo"]);
$descr = mysqli_real_escape_string($conn, $_POST["descr"]);
$colore = mysqli_real_escape_string($conn, $_POST["colore"]);
$n_scaffali = mysqli_real_escape_string($conn, $_POST["n_scaffali"]);

$sql = "SELECT id FROM libreria WHERE id_utente = '$id_utente' AND id = $id";
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

if($result && $result->num_rows == 1){

    $sql = "UPDATE libreria SET nome = '$titolo', descr = '$descr', n_scaffali = $n_scaffali, colore = '$colore' WHERE id = $id";
    $result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

    if($result){
        $result = array(
            "success" => true,
            "content" => "  <div class='immagine_pillola_libro' style='background-color: ".$colore."'></div><!--
                             --><div class='testo_pillola_libro'>
                                    <p class='titolo_pillola_libro'>".$titolo."</p>".$descr."
                            </div>"
        );
        echo json_encode($result);
    }else{
        $result = array(
            "success" => false,
            "content" => "Modifiche non salvate.."
        );
        echo $result;
    }
}
mysqli_close($conn);