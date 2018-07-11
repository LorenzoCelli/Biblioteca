<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

$id_utente = $_SESSION['id_utente'];
$id_libro = $_GET["id"];
include '../connection.php';

$sql = "SELECT * FROM libri WHERE id_utente = ".$id_utente." AND id = ".$id_libro;
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

if($result->num_rows == 0){
    echo "<img src='http://pa1.narvii.com/6776/24a0a36313ea44f1abac45bcc3c70465fd27f0a2_00.gif' height='200px'>";
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
if ($gen->num_rows == 0) $generi = "---";
else{
    while ($gen = mysqli_fetch_assoc($gen)) $generi.=$gen['genere']."-";
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
<div class="info_button_bar">
    <div onclick="edit_book(<?echo $id_libro;?>)" class="info_hover_div"><img src="../imgs/matita.svg" style="height: 50px"></div><!--
 --><div onclick="delete_book(<?echo $id_libro;?>,this)" class="info_hover_div"><img src="../imgs/cestino.svg" style="height: 50px"></div><!--
 --><div onclick="close_info_menu()" class="info_hover_div"><img src="../imgs/croce.svg" style="height: 50px"></div>
</div>
<div id="new_menu_img" class="book_image" style="background-image: url('<?echo $img_url;?>')"></div>
<div class="info_box">
    <div style="display: none" class="info_tooltip">titolo</div>
    <h1 class="info_p"><?echo $titolo;?></h1>
</div>
<hr>
<div class="info_box">
    <div style="display: none" class="info_tooltip">autore</div>
    <h2 class="info_p"><?echo $autore?></h2>
</div>
<div class="info_box">
    <div class="info_tooltip">libreria</div>
    <div class="info_p"><?echo $libreria?></div>
</div>
<div class="info_box">
    <div class="info_tooltip">scaffale</div>
    <div class="info_p"><?echo $scaffale?></div>
</div>
<div class="info_box">
    <div class="info_tooltip">isbn</div>
    <div class="info_p"><?echo $isbn?></div>
</div>

<div class="info_box">
    <div style="display: none" class="info_tooltip">descrizione</div>
    <div class="info_p"><?echo $descr?></div>
</div>
<div class="info_box">
    <div style="display: none" class="info_tooltip">generi</div>
    <div class="info_p"><?echo $generi?></div>
</div>