<?php session_start();
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';
include $_SERVER['DOCUMENT_ROOT'].'/controllo_set.php';

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
    <title>Biblioteca - Librerie</title>
    <link rel="stylesheet" type="text/css" href="/opensans/opensans.css">
    <link rel="stylesheet" type="text/css" href="/libri/libri.css">
    <link rel="stylesheet" type="text/css" href="/librerie/librerie.css">
    <link href="https://fonts.googleapis.com/css?family=Vollkorn:400,900" rel="stylesheet">
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
        <a href=""><button  disabled>Librerie</button></a>
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
            <button onclick="ordina(this, 'az')">dalla a alla z</button>
            <button onclick="ordina(this, 'za')" style="border: none">dalla z alla a</button>
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

        <div class="tasto_menu"><img onclick="chiama_menu_principe()" src="../imgs/menu.svg"></div>

        <div onclick="apri_menu_volante('account')" class="scatola_account">
            <p><?php echo $uname;?></p>
            <img src=<?php echo $img; ?>>
        </div>
        <div id="menu_account" style="border-top-left-radius: 0; left: 200px; top: 200px">
            <button class="account_button" disabled>Il tuo account</button>
            <button class="account_button">Impostazioni</button>
            <button style="border-bottom: none" class="account_button">Logout</button>
        </div>

        <h1 style="color: white; margin: 0; line-height: 30px"> Le tue librerie. </h1>

        <div class="barra_bottoni"><!--
         --><div onclick="chiama_menu_aggiungi()"><img src="../imgs/piu.svg"></div><!--
         --><div onclick="apri_menu_volante('ordina')"><img  src="../imgs/ordina.svg"></div><!--
         --><div onclick="chiama_barra_ricerca()" ><img src="../imgs/lente.svg"></div><!--
         --><input id="barra_ricerca" class="menu_input" type="text"></div><input placeholder="cerca.." id="seconda_barra_ricerca" type="text">


        <div id="pillole_libro">
         <?php

         $sql = "SELECT * FROM libreria WHERE id_utente = '$id_utente'";
         $result = mysqli_query($conn, $sql);

         while($row = mysqli_fetch_assoc($result)){
           echo "
            <div class='pillola_libro' onclick='info_libreria(".$row['id'].")'>
                <div class='immagine_pillola_libro' style='background-color: ".$row['colore']."'></div><!--
             --><div class='testo_pillola_libro'>
                    <div class='titolo_pillola_libro'>".$row['nome']."</div><div>".$row['descr']."</div>
                </div>
            </div>
           ";
         }
         ?>
        </div>

       </div>
     </div>

<!--
New book aside
-->

<div id="menu_aggiungi" style="left: 100%">
  <form>
  <h1>Nuova libreria</h1>
    <input type="text" placeholder="Nome libreria" name="nome" required><br>
    <input type="text" placeholder="Descrizione" name="descr"><br>
    Colore etichetta:
    <div class="etichetta" onclick="chiama_color_picker()"></div>
    <div class="box_colorpicker">
      <img onmousedown="ciao(event)" src="../imgs/line.png">
      <div></div>
    </div>
    <script>document.write()</script>
    <h2 style="margin: 5px 0">Aggiungi scaffali</h2>
    Numero scaffali: <input type="number" id="counter" value="1" name="n_scaffali" oninput="nuovi_scaffali()">
    <div class="primo_scaffale">
        <img src="../imgs/libri.svg">
    </div><div class="box_scaffali"></div>
    <div class="menu_scaffale">
        <div onclick="nuovo_scaffale()" style="border-right: 1px solid #cbcbcb;"><img src="../imgs/scaffale_piu.svg"></div><div onclick="rimuovi_scaffale()"><img src="../imgs/scaffale_meno.svg"></div>
    </div>
    <button onclick="nuova_libreria(this)">Crea nuova libreria</button>
    <input type="reset" name="newlibraryButton" value="Annulla" onclick="azzera_menu_aggiungi()">
  </form>
</div>

<div id="menu_info" style="left: 100%;">
</div>

<div id="menu_info2" style="left: 100%;">
</div>

<script src="/librerie/colorpicker.js"></script>
<script src="/libri/comune.js"></script>
<script src="/libri/libri.js"></script>
<script src="/librerie/librerie.js"></script>
</body>
</html>
