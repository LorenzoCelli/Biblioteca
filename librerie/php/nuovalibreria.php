<?php
session_start();

error_reporting(-1);
ini_set('display_errors', 'On');

$id_utente = $_SESSION['id_utente'];
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

$nome = mysqli_real_escape_string($conn, $_POST["nome"]);
$descr = mysqli_real_escape_string($conn,$_POST["descr"]);
$scaffali = mysqli_real_escape_string($conn,$_POST["scaffali"]);
$colore = mysqli_real_escape_string($conn,$_POST["colore"]);

$sql = "INSERT INTO libreria (id_utente,nome,descr, n_scaffali,colore)
VALUES ('$id_utente','$nome','$descr',$scaffali,'$colore')";
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));;

if ($result){
    $last_id = $conn->insert_id;
    echo "
    <div class='pillola_libro' onclick='info_libreria(".$last_id.")'>
        <div class='immagine_pillola_libro' style='background-color: ".$colore."'></div><!--
     --><div class='testo_pillola_libro'>
            <p class='titolo_pillola_libro'>".$nome."</p>".$descr."
        </div>
    </div>
    ";
} else echo "qualcosa è andato storto col database";

mysqli_close($conn);

?>
