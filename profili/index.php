<?php session_start();
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';
include $_SERVER['DOCUMENT_ROOT'].'/controllo_set.php';

$id_profilo = $_GET['id_profilo'];
$uname_profilo = $_GET['uname_profilo'];
$uname = $_SESSION['uname'];
$id_utente = $_SESSION['id_utente'];
$sql = "SELECT id_avatar FROM utenti WHERE id = '$id_utente'";
$row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
$id_avatar = $row['id_avatar'];
$img = avatar($id_avatar);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca - Profili</title>
    <link rel="stylesheet" type="text/css" href="/opensans/opensans.css" >
    <link rel="stylesheet" type="text/css" href="/libri/libri.css">
    <link rel="stylesheet" type="text/css" href="/profili/profili.css">
    <link href="https://fonts.googleapis.com/css?family=Vollkorn:400,600,900" rel="stylesheet">
</head>
<body>

<!--
|--------------------------------------------------------------|
|                                                              |
|  Contenitore principale                                      |
|                                                              |
|--------------------------------------------------------------|
-->

<div id="main_container">
    <div id="menu_principe">
        <a href="/libri/"><button>Biblioteca</button></a>
        <a href="/librerie/"><button>Librerie</button></a>
        <a href="/amici/"><button>Amici</button></a>
        <a href="/prestiti/"><button>Prestiti</button></a>
        <a href="/messaggi/"><button>Messaggi</button></a>
    </div><!--
 --><div class="content">
        <!--
        |--------------------------------------------------------------|
        |  Menu volante ordina                                         |
        |--------------------------------------------------------------|
        -->
        <div id="menu_volante_ordina" class="menu_volante">
            <div>Ordina:</div>
            <button onclick="ordina(this, 'autoreaz')">Autore A-Z</button>
            <button onclick="ordina(this, 'autoreza')">Autore Z-A</button>
            <button onclick="ordina(this, 'titoloaz')">Titolo A-Z</button>
            <button onclick="ordina(this, 'titoloza')">Titolo Z-A</button>
            <button onclick="ordina(this, 'generi')">Generi</button>
            <button onclick="ordina(this, 'libreria')" style="border: none">Libreria</button>
        </div>
        <!--
        |--------------------------------------------------------------|
        |  Menu volante account                                        |
        |--------------------------------------------------------------|
        -->
        <div id="menu_volante_account" class="menu_volante">
            <div>Il tuo account:</div>
            <button onclick="window.location.href='/account/'">impostazioni</button>
            <button onclick="window.location.href='/logout.php'" style="border: none">logout</button>
        </div>

        <div style="border-radius: 0 10px 10px 0; height: 50px; width:50px; position: absolute; top:20px; left: 0; background-color: #f8f8f8; display: inline-block"><img onclick="chiama_menu_principe()" src="../imgs/menu.svg" style="height: 50px"></div>

        <div onclick="apri_menu_volante('account')" class="scatola_account">
          <p><?php echo $uname;?></p>
          <img src=<?php echo $img; ?>>
        </div>

        <?php
        $sql = "SELECT * FROM preferiti WHERE id_utente=$id_utente AND id_biblioteca=$id_profilo";
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows == 0) {
          echo "<img src='/imgs/stellaoff.png' id='stellina' onclick='aggiungi_preferiti($id_profilo)'>";
        }else{
          echo "<img src='/imgs/stellaon.png' id='stellina' onclick='aggiungi_preferiti($id_profilo)'>";
        }
        ?>
        <h1 style="color:white;margin:0;line-height:30px;display:inline-block;"> La biblioteca di <?php echo $uname_profilo; ?>.</h1><br>

        <div class="barra_bottoni"><!--
         --><div onclick="espandi_pillole()"><img src="/imgs/occhio.svg"></div><!--
         --><div onclick="apri_menu_volante('ordina')"><img src="/imgs/ordina.svg"></div><!--
         --><div onclick="chiama_barra_ricerca()"><img src="/imgs/lente.svg"></div><!--
         --><input id="search_bar" class="menu_input" type="text"></div>
        <br>

        <div id="pillole_libro">
        <?php

        $sql = "SELECT * FROM libri WHERE id_utente = '$id_profilo'";
        $result = mysqli_query($conn, $sql);

        if ($result->num_rows == 0) {
          echo "<p>Non ha ancora aggiunto libri alla sua biblioteca</p>";
        }else{
          while($row = mysqli_fetch_assoc($result)){
            echo "
            <div class='pillola_libro' onclick='info_libro_amico(".$row['id'].")'>
            <div class='immagine_pillola_libro' style='background-image: url(".$row['img_url'].")'></div><!--
            --><div class='testo_pillola_libro'>
            <p class='titolo_pillola_libro'>".$row['titolo']."</p>
            ".$row['autore']."
            </div>
            </div>
            ";
          }
        }
        ?>
        </div>
    </div></div>

<!--
|--------------------------------------------------------------|
|                                                              |
|  Menu info libro                                             |
|                                                              |
|--------------------------------------------------------------|
-->

<div id="menu_info" style="left: 100%">
</div>


<script src="/quaggaJS/quagga.js"></script>
<script src="/libri/comune.js"></script>
<script src="/libri/libri.js"></script>
<script src="/profili/profili.js"></script>
</body>
</html>
