<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La tua biblioteca</title>
    <link rel="stylesheet" type="text/css" href="../main/nuovolibro.css">
    <link rel="stylesheet" type="text/css" href="nuovalibreria.css">
    <link href="https://fonts.googleapis.com/css?family=Vollkorn:400,900" rel="stylesheet">
</head>
<body>

<!--
Main container
-->

<div id="a" class="main_container">
    <div class="menu_aside">

    </div><!--
 --><div class="content">
        <img onclick="slide_right('a')" src="../imgs/menu.svg" style="position: absolute; top: 0; left: -1px; height: 90px;cursor: pointer;">

        <h1 style="color: white"> Le tue librerie. </h1>

        <div style="margin:10px 0; background-color: #f8f8f8; border-radius: 50px; overflow: hidden; height:50px; display: inline-block"><!--
        --><div class="hover_button" onclick="slide_left('new_library')"><img class="menu_button" src="../imgs/piu.svg"></div><!--
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
           --><div class='book_text2'> ".$row['nome']." </div>
          </div>
          ";
        }
        ?>

        <div class="book_container">
            <div class="book_image" style="background-image: url(../imgs/newsc11.png)"></div><!--
         --><div class="book_text2"> Libreria #1 </div>
        </div>
        <div class="book_container">
            <div class="book_image" style="background-image: url(../imgs/newsc11.png)"></div><!--
         --><div class="book_text2"> Libreria #2 </div>
        </div>
        <div class="book_container">
            <div class="book_image" style="background-image: url(../imgs/newsc11.png)"></div><!--
         --><div class="book_text2"> Libreria #3 </div>
        </div>
    </div></div>

<!--
New book aside
-->

<div class="aside" style="left: 100%" id="new_library">
  <button id="buttonX" onclick="slide_left('new_library')">x</button><br>
  <h1>Nuova libreria</h1>
  <form>
    <div class="form">
      <input type="text" placeholder="Nome libreria" name="nome"><br>
      <input type="text" placeholder="Descrizione" name="descr"><br>
      <input type="color" name="colore"><br><br>
      <p>Numero scaffali: <input type="text" id="counter" value="1" name="n_scaffali" disabled></p>
      <img class="tasto" onclick="addLibrary('../imgs/newsc111.png')" src="../imgs/tasto2.png">
      <img src="../imgs/newsc11.png" width="300" height="100" alt="scaffale" class="scaffale">
    </div>
  <img class="tasto" onclick="addLibrary('../imgs/newsc111.png')" src="../imgs/tasto2.png">
  <input type="submit" name="newlibraryButton" value="Crea nuova libreria" style="margin-top:15%">
  <input type="reset" name="newlibraryButton" value="Annulla" onclick="slide_left('new_library')">
  </form>
</div>

<script src="mylibrary.js"></script>
</body>
</html>
