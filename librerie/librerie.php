<?php session_start();
$uname = $_SESSION['uname'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le tue librerie</title>
    <link rel="stylesheet" type="text/css" href="../opensans/opensans.css">
    <link rel="stylesheet" type="text/css" href="../main/main.css">
    <link rel="stylesheet" type="text/css" href="librerie.css">
    <link href="https://fonts.googleapis.com/css?family=Vollkorn:400,900" rel="stylesheet">
</head>
<body>

<!--
Main container
-->

<div id="main_container">
    <div id="main_menu">
      <a href="../main/main.php"><button style="border-radius: 10px 10px 0 0" class="main_menu_button">La mia biblioteca</button></a>
      <a href=""><button class="main_menu_button" disabled>Le mie librerie</button></a>
      <a href=""><button class="main_menu_button">Annulla</button></a>
      <a href=""><button style="border-bottom:1px solid #cbcbcb; border-radius: 0 0 10px 10px" class="main_menu_button">Annulla</button></a>
    </div><!--
 --><div class="content">
         <div id="little_menu_box">
           <button class="little_menu_button" style="height: 30px" disabled>ordina per:</button>
           <button class="little_menu_button">nome</button>
           <button class="little_menu_button">autore</button>
           <button style="border-bottom: none" class="little_menu_button">genere</button>
         </div>

        <img onclick="slide_right('main_container')" src="../imgs/menu.svg" style="position:absolute;top:0;left:-1px;height:90px;cursor:pointer;">

        <a onclick="show_menu_account()"><div class="account_container">
          <p2 id="nome_utente"><?php echo $uname;?></p2>
          <img src="../imgs/usericon.svg" alt="icona_utente_non_trovata" style="width:50px;height:50px;">
        </div></a>
        <div id="menu_account">
            <button class="account_button" disabled>Il tuo account</button>
            <button class="account_button">Impostazioni</button>
            <button style="border-bottom: none" class="account_button">Logout</button>
        </div>

        <h1 style="color: white"> Le tue librerie. </h1>

        <div class="button_bar"><!--
        --><div class="hover_button" onclick="slide_left('new_menu')"><img class="menu_button" src="../imgs/piu.svg"></div><!--
         --><div class="hover_button"><img class="menu_button" src="../imgs/ordina.svg"></div><!--
         --><div onclick="show_hide('search_bar')" class="hover_button"><img style="border: none" class="menu_button" src="../imgs/lente.svg"></div><!--
         --><input id="search_bar" class="menu_input" type="text"></div>
        <br>

        <?php

        $id_utente = $_SESSION['id_utente'];

        include '../connection.php';

        $sql = "SELECT * FROM libreria WHERE id_utente = '$id_utente'";
        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result)){
          echo "
          <div class='book_container'>
              <div class='book_image' style='background-image: url(../imgs/newsc11.png)'></div><!--
           --><div class='book_text'> ".$row['nome']." </div>
          </div>
          ";
        }
        ?>

        <div class="book_container" pippo="ciao">
          <div class="etichettalib">
          </div>
          <div class="library_img">
            <img src="bookshelf.svg" width="170px">
          </div>
          <div class="library_text">
            <p class="library_title">Libreria #1</p>
            </div>
          </div>
          <div class="book_container" pippo="ciao">
            <div class="etichettalib">
            </div>
            <div class="library_img">
              <img src="bookshelf.svg" width="170px">
            </div>
            <div class="library_text">
              <p class="library_title">Libreria #</p>
              </div>
            </div>
        </div>
    </div></div>

<!--
New book aside
-->

<div id="new_menu" style="left: 100%">
  <h1>Nuova libreria</h1>
  <form action="script.php" method="post">
    <div class="form">
      <input type="text" placeholder="Nome libreria" name="nome"><br>
      <input type="text" placeholder="Descrizione" name="descr"><br>
      <div class="colorContainer" onclick="changeHeightDown();">
        <span id="pickerTitle">Colore etichetta</span>
        </div>
        <div id="pickerAnimation">
        <ul id="listaColori">
          <div class="colore" id="rosso" onclick="getColor('red');"><img src="../imgs/check2.svg" width="32px" height="32px" id="check" name="red"></div>
          <div class="colore" id="verde" onclick="getColor('MediumSeaGreen');"><img src="../imgs/check2.svg" width="32px" height="32px" id="check" name="MediumSeaGreen"></div>
          <div class="colore" id="viola" onclick="getColor('purple');"><img src="../imgs/check2.svg" width="32px" height="32px" id="check" name="purple"></div>
          <div class="colore" id="blu" onclick="getColor('DodgerBlue');"><img src="../imgs/check2.svg" width="32px" height="32px" id="check" name="DodgerBlue"></div>
          <div class="colore" id="arancio" onclick="getColor('Orange');"><img src="../imgs/check2.svg" width="32px" height="32px" id="check" name="Orange"></div>
          <div class="colore" id="rosa" onclick="getColor('Violet');"><img src="../imgs/check2.svg" width="32px" height="32px" id="check" name="Violet"></div>
          <div class="colore" id="verdeacqua" onclick="getColor('#20B2AA');"><img src="../imgs/check2.svg" width="32px" height="32px" id="check" name="#20B2AA"></div>
      </ul>
    </div>
    <h1 style="margin-top: 20px;">Aggiungi scaffali</h1>
    <div class="tasti">
    <div class="tasto" id="destro" onclick="addLibrary('../imgs/newsc111.png')"><p id="piu">Aggiungi</p></div>
    <div class="tasto" id="sinistro" onclick="removeLibrary()"><p id="meno">Rimuovi</p></div>
  </div>
    <div class="containerScaffali">
      <p style="font-size: 20px;margin-bottom: 8px;">Numero scaffali: <input type="number" id="counter" value="1" name="n_scaffali" oninput="addMoreLibrary('../imgs/newsc111.png')"></p>
      <img src="../imgs/newsc11.png" height="100" alt="scaffale" class="scaffale">
    </div>
    </div>
    <input type="submit" name="newlibraryButton" value="Crea nuova libreria" style="margin-top:15%">
    <input type="reset" name="newlibraryButton" value="Annulla" onclick="slide_left('new_menu')">
  </form>
</div>

<script src="librerie.js"></script>
<script src="../main/main.js"></script>
</body>
</html>
