<?php

error_reporting(-1);
ini_set('display_errors', 'On');

session_start();
$id_utente = $_SESSION['id_utente'];
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

$id_prestito = mysqli_real_escape_string($conn,$_GET["id_prestito"]);

$sql = "SELECT * FROM prestiti
INNER JOIN libri ON libri.id = prestiti.id_libro
INNER JOIN utenti ON prestiti.id_debitore = utenti.id
WHERE prestiti.id_prestito=$id_prestito AND prestiti.id_creditore=$id_utente";
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

if($result->num_rows == 0){
    echo "<img src='http://pa1.narvii.com/6776/24a0a36313ea44f1abac45bcc3c70465fd27f0a2_00.gif' height='200px'>";
    return;
}

$row = mysqli_fetch_assoc($result);
$img_url = $row['img_url'];
$titolo = $row['titolo'];
$uname_debitore = $row['username'];
date_default_timezone_set('Europe/Rome');
$timestamp = strtotime($row['data_inizio']);
$data_inizio = date('d-m-Y', $timestamp);
$timestamp = strtotime($row['data_promemoria']);
$data_promemoria = date('d-m-Y', $timestamp);

?>

<div class="info_barrabottoni">
    <div onclick="modifica_libro(<?echo $id_libro;?>)"><img src="../imgs/matita.svg"></div><!--
 --><div onclick="elimina_libro(<?echo $id_libro;?>,this)"><img src="../imgs/cestino.svg"></div><!--
 --><div onclick="chiudi_menu_info()"><img src="../imgs/croce.svg"></div>
</div>

<div id="img_aggiungi" class="immagine_pillola_libro" style="background-image: url('<?php echo $img_url;?>')"></div>

<h1><?php echo $titolo;?></h1>
<h3>L'hai prestato a: <?php echo $uname_debitore;?></h3>
<h3>Il giorno: <?php echo $data_inizio;?></h3>
<h3>Da restituire entro: <?php echo $data_promemoria;?></h3>







<?php mysqli_close($conn); ?>
