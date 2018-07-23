<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

$id_utente = $_SESSION['id_utente'];
$ordina = mysqli_real_escape_string($conn,$_POST['ordina']);

if ($ordina == 'az') {
  $sql = "SELECT * FROM libreria
  WHERE id_utente = '$id_utente'
  ORDER BY nome ASC";
}elseif ($ordina == 'za') {
  $sql = "SELECT * FROM libreria
  WHERE id_utente = '$id_utente'
  ORDER BY nome DESC";
}

$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

if(!$result){
    return;
}

while($row = mysqli_fetch_assoc($result)){
    echo "
    <div class='pillola_libro' onclick='info_libreria(".$row["id"].")'>
        <div class='immagine_pillola_libro' style='background-color: ".$row["colore"]."'></div><!--
     --><div class='testo_pillola_libro'>
            <p class='titolo_pillola_libro'>".$row["nome"]."</p>".$row["descr"]."
        </div>
    </div>
    ";
}
?>
