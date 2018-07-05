<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La tua biblioteca</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="nuovolibro.css">
    <link href="https://fonts.googleapis.com/css?family=Vollkorn:400,900" rel="stylesheet">
</head>
<body>

<!--
Main container
-->

<div id="a" class="main_container">
    <div class="menu_aside">
        <input style="border-radius: 10px 10px 0 0" class="side_menu_button" type="button" value="annulla">
        <input class="side_menu_button" type="button" value="annulla">
        <input class="side_menu_button" type="button" value="annulla">
        <input style="border-bottom:1px solid #cbcbcb; border-radius: 0 0 10px 10px" class="side_menu_button" type="button" value="annulla">
    </div><!--
 --><div class="content">
        <img id="angolo" onclick="slide_right('a')" src="../imgs/menu.svg" style="position: absolute; top: 0; left: -1px; height: 90px">

        <h1 style="color: white"> La tua biblioteca. </h1>

        <div style="margin:10px 0; background-color: #f8f8f8; border-radius: 50px; overflow: hidden; height:50px; display: inline-block"><!--
         --><div class="hover_button" onclick="slide_left('new_book')"><img class="menu_button" src="../imgs/piu.svg"></div><!--
         --><div class="hover_button"><img class="menu_button" src="../imgs/ordina.svg"></div><!--
         --><div onclick="show_hide('search_bar')" class="hover_button"><img style="border: none" class="menu_button" src="../imgs/lente.svg"></div><!--
         --><input id="search_bar" class="menu_input" type="text"></div>
        <br>

        <?php

        $id_utente = $_SESSION['id_utente'];

        include '../connection.php';

        $sql = "SELECT * FROM libri WHERE id_utente = '$id_utente'";
        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result)){
          echo "
          <div class='book_container' onclick='ingrandisci(this);'>
              <div class='book_image' style='background-image: url()'></div><!--
           --><div class='book_text'>
                ".$row['titolo']."
              </div>
              <div class='book_info'>
                Autore: ".$row['autore']."<br>
                Descrizione: ".$row['desc']."<br>
                Generi:
          ";
          $id_libro = $row['id'];
          $generi = mysqli_query($conn, "SELECT * FROM generi WHERE id_libro = '$id_libro'");
          if ($generi->num_rows == 0) echo "---";
          else{
            while ($gen = mysqli_fetch_assoc($generi)) echo $gen['genere']."<br>";
          }
          echo "

              </div>
          </div>
          ";
        }

        ?>

        <div class="book_container">
            <div class="book_image" style="background-image: url(https://images-na.ssl-images-amazon.com/images/I/51V%2Bb2rUV3L._SX356_BO1,204,203,200_.jpg)"></div><!--
         --><div class="book_text"> La mia casa è dove sono </div>
        </div>
        <div class="book_container">
            <div class="book_image" style="background-image: url(https://mr.comingsoon.it/imgdb/PrimoPiano/impaginate/AnimaliFantastici.jpg)"></div><!--
         --><div class="book_text"> Gino Bottiglieri </div>
        </div>
        <div class="book_container">
            <div class="book_image" style="background-image: url(http://pennablu.it/img/copertina.jpg)"></div><!--
         --><div class="book_text"> asdads </div>
        </div>
    </div></div>

<!--
New book aside
-->

<div class="aside" style="left: 100%" id="new_book">
    <h1>Nuovo libro</h1>
    <form>
        <input type="text" placeholder="ISBN"><br>
        <input type="text" placeholder="Titolo"><br>
        <input type="text" placeholder="Autore"><br>
        <h2>Dove si trova?</h2>
        <div class="select_box">
            <div class="select_box_text">Libreria:</div>
            <select>
                <option>Libreria rossa</option>
                <option>Libreria verde</option>
                <option>Libreria arancione</option>
            </select>
        </div>
        <br>
        <div class="select_box">
            <div class="select_box_text">Scaffale:</div>
            <select>
                <option>1</option>
                <option>2</option>
                <option>3</option>
            </select>
        </div><br>
        <input style="margin-top: 30px" type="submit" value="aggiungi"><br>
        <input type="button" value="annulla" onclick="slide_left('new_book')">
    </form>
</div>

<script src="nuovolibro.js"></script>
</body>
</html>
