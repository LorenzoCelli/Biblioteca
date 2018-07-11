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

$sql = "SELECT * FROM posizione WHERE id_libro = ".$id_libro;
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

$scaffale = "";
$libreria = "";
if($result && $result->num_rows > 0){
    $row = mysqli_fetch_assoc($result);
    $scaffale = $row["n_scaffale"];
    $id_libreria = $row["id_libreria"];

    $sql = "SELECT nome FROM libreria WHERE id_libreria = ".$id_libreria;
    $result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

    if($result){
        $row = mysqli_fetch_assoc($result);
        $nome_libreria = $row["nome"];
    }
}

?>
<div class="info_button_bar">
    <div onclick="edit_menu(<?echo $id_libro;?>)" class="info_hover_div"><img src="../imgs/matita.svg" style="height: 50px"></div><!--
 --><div onclick="close_info_menu()" class="info_hover_div"><img src="../imgs/croce.svg" style="height: 50px"></div>
</div>
<div id="new_menu_img" class="book_image" style="background-image: url('<?echo $img_url;?>')"></div>
<h1 class="info_p, info_title"><?echo $titolo;?></h1>
<hr class="info_p">
<h2 class="info_p"><?echo $autore?></h2>
<p class="info_p"><b class="info_b">Libreria</b> <?echo $libreria?></p>
<p class="info_p"><b class="info_b">Scaffale</b> <?echo $scaffale?></p>
<p class="info_p"><b class="info_b">ISBN</b> <?echo $isbn?></p>

<p class="info_p"><?echo $descr?></p>
<p class="info_p"><b class="info_b"> Generi: </b><?echo $generi?></p>