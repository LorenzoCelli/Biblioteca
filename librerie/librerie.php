<?php session_start();
$uname = $_SESSION['uname'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La tua biblioteca</title>
    <link rel="stylesheet" type="text/css" href="../main/nuovolibro.css">
    <link rel="stylesheet" type="text/css" href="nuovalibreria.css">
    <link href="https://fonts.googleapis.com/css?family=Vollkorn:400,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
</head>
<body>

<!--
Main container
-->

<div id="main_container">
    <div id="main_menu">
      <input style="border-radius: 10px 10px 0 0" class="main_menu_button" type="button" value="La mia biblioteca">
      <input class="main_menu_button" type="button" value="Le mie librerie" disabled>
      <input class="main_menu_button" type="button" value="annulla">
      <input style="border-bottom:1px solid #cbcbcb; border-radius: 0 0 10px 10px" class="main_menu_button" type="button" value="annulla">
    </div><!--
 --><div class="content">
         <div id="little_menu_box">
           <button class="little_menu_button" style="height: 30px" disabled>ordina per:</button>
           <button class="little_menu_button">nome</button>
           <button class="little_menu_button">autore</button>
           <button style="border-bottom: none" class="little_menu_button">genere</button>
         </div>

        <img onclick="slide_right('main_container')" src="../imgs/menu.svg" style="position:absolute;top:0;left:-1px;height:90px;cursor:pointer;">
        <div class="" style="position:absolute;top:5px;right:20px;height:auto;padding:3px;">
          <p2 style="line-height:50px;vertical-align:top;padding:3px;margin-right:5px;"><?php echo $uname;?></p2>
          <img src="../imgs/usericon.png" alt="icona_utente_non_trovata" style="width:50px;height:50px;">
        </div>
        <h1 style="color: white"> Le tue librerie. </h1>

        <div style="margin:10px 0; background-color: #f8f8f8; border-radius: 50px; overflow: hidden; height:50px; display: inline-block"><!--
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

<div id="new_menu" style="left: 100%">
  <button id="buttonX" onclick="slide_left('new_menu')">x</button><br>
  <h1>Nuova libreria</h1>
  <form>
    <div class="form">
      <input type="text" placeholder="Nome libreria" name="nome"><br>
      <input type="text" placeholder="Descrizione" name="descr"><br>
      <input type="color" name="colore"><br><br>
      <p>Numero scaffali: <input type="text" id="counter" value="1" name="n_scaffali" disabled></p>
      <img class="tasto" onclick="removeLibrary()" src="../imgs/tasto3.png">
      <img src="../imgs/newsc11.png" width="300" height="100" alt="scaffale" class="scaffale">
    </div>
  <img class="tasto" onclick="addLibrary('../imgs/newsc111.png')" src="../imgs/tasto2.png">
  <input type="submit" name="newlibraryButton" value="Crea nuova libreria" style="margin-top:15%">
  <input type="reset" name="newlibraryButton" value="Annulla" onclick="slide_left('new_menu')">
  </form>
</div>

<script src="mylibrary.js"></script>
<script src="../main/nuovolibro.js"></script>
</body>
</html>
