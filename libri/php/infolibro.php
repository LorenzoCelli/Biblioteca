<?php
session_start();

error_reporting(-1);
ini_set('display_errors', 'On');

$id_utente = $_SESSION['id_utente'];
$id_libro = $_GET["id"];
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

$sql = "SELECT * FROM libri WHERE id_utente = ".$id_utente." AND id = ".$id_libro;
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

if($result->num_rows == 0){
    echo "<l_img src='http://pa1.narvii.com/6776/24a0a36313ea44f1abac45bcc3c70465fd27f0a2_00.gif' height='200px'>";
    return;
}

$row = mysqli_fetch_assoc($result);
$id_libro = $row["id"];
$titolo = $row["titolo"];
$autore = $row["autore"];
$descr = $row["descr"];
$isbn = $row["isbn"];
$img_url = $row["img_url"];
$generi = "";

$gen = mysqli_query($conn, "SELECT * FROM generi WHERE id_libro = ".$id_libro);
if ($gen->num_rows == 0) $generi = "nessuno";
else{
    while ($g = mysqli_fetch_assoc($gen)){
        $generi.=$g['genere'].", ";
    }
    $generi = rtrim($generi,", ");
}

$sql = "SELECT libreria.nome, posizione.n_scaffale FROM libreria INNER JOIN posizione ON libreria.id = posizione.id_libreria WHERE id_libro = ".$id_libro;
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

$scaffale = "";
$libreria = "";
if($result && $result->num_rows > 0){
    $row = mysqli_fetch_assoc($result);
    $scaffale = $row["n_scaffale"];
    $libreria = $row["nome"];
}

?>
<div class="info_barrabottoni">
    <div onclick="modifica_libro(<?echo $id_libro;?>)"><img src="../imgs/matita.svg""></div><!--
 --><div onclick="elimina_libro(<?echo $id_libro;?>,this)"><img src="../imgs/cestino.svg"></div><!--
 --><div onclick="chiudi_menu_info()"><img src="../imgs/croce.svg"></div>
</div>
<div id="img_aggiungi" class="immagine_pillola_libro" style="background-image: url('<?echo $img_url;?>')"></div>
<div class="scatola_info">
    <div style="display: none" class="nome_scatola_info">titolo</div>
    <h1 class="testo_scatola_info"><?echo $titolo;?></h1>
</div>
<hr>
<div class="scatola_info">
    <div style="display: none" class="nome_scatola_info">autore</div>
    <h2 class="testo_scatola_info"><?echo $autore?></h2>
</div>
<div class="scatola_info">
    <div class="nome_scatola_info">libreria</div>
    <div class="testo_scatola_info"><?echo $libreria?></div>
</div>
<div class="scatola_info">
    <div class="nome_scatola_info">scaffale</div>
    <div class="testo_scatola_info"><?echo $scaffale?></div>
</div>
<div class="scatola_info">
    <div class="nome_scatola_info">isbn</div>
    <div class="testo_scatola_info"><?echo $isbn?></div>
</div>

<div class="scatola_info">
    <div style="display: none" class="nome_scatola_info">descrizione</div>
    <div class="testo_scatola_info"><?echo $descr?></div>
</div>
<div class="scatola_info">
    <div class="nome_scatola_info">generi</div>
    <div class="testo_scatola_info"><?echo $generi?></div>
</div>
<div class="scatola_info">
    <div style="display: none" class="nome_scatola_info">img_url</div>
    <div style="display: none" class="testo_scatola_info"><?echo $img_url;?></div>
</div>
<?php
mysqli_close($conn);