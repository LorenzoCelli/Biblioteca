<?php session_start();
$uname = $_SESSION['uname'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La tua biblioteca</title>
    <link rel="stylesheet" type="text/css" href="nuovolibro.css">
    <link href="https://fonts.googleapis.com/css?family=Vollkorn:400,600,900" rel="stylesheet">
    <link href="../opensans/opensans.css" rel="stylesheet">
</head>
<body>

<!--
Main container
-->

<div id="main_container">
    <div id="main_menu">
        <a href=""><button class="main_menu_button" disabled>La mia biblioteca</button></a>
        <a href="../librerie/librerie.php"><button class="main_menu_button">Le mie librerie</button></a>
        <a href=""><button class="main_menu_button">I miei amici</button></a>
        <a href=""><button class="main_menu_button">Tua sorella</button></a>
    </div><!--
 --><div class="content">
        <div id="little_menu_box">
            <button class="little_menu_button" style="height: 30px" disabled>ordina per:</button>
            <button class="little_menu_button">nome</button>
            <button class="little_menu_button">autore</button>
            <button style="border-bottom: none" class="little_menu_button">genere</button>
        </div>

        <div style="border-radius: 0 0 10px 0; height: 50px; width:50px; position: absolute; top:0; left: 0; background-color: #f8f8f8; display: inline-block"><img onclick="slide_main_menu()" src="../imgs/menu.svg" style="height: 50px"></div>
        <div class="account_container">
          <p2 id="nome_utente"><?php echo $uname;?></p2>
          <div style="display: inline-block; height: 50px; width: 50px; overflow: hidden"><img src="../imgs/usericon.svg" alt="icona_utente_non_trovata" style="width:50px;height:50px;"></div>
        </div>

        <h1 style="color: white; margin: 0; line-height: 30px"> La tua biblioteca. </h1>

        <div class="button_bar"><!--
         --><div class="hover_button" onclick="slide_new_menu()"><img class="menu_button" src="../imgs/piu.svg"></div><!--
         --><div onclick="show_little_menu()" class="hover_button"><img class="menu_button" src="../imgs/ordina.svg"></div><!--
         --><div onclick="slide_search_bar()" class="hover_button"><img style="border: none" class="menu_button" src="../imgs/lente.svg"></div><!--
         --><input id="search_bar" class="menu_input" type="text"></div>
        <br>

        <?php

        $id_utente = $_SESSION['id_utente'];

        include '../connection.php';

        $sql = "SELECT * FROM libri WHERE id_utente = '$id_utente'";
        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result)){
          echo "
          <div class='book_container' onclick='fill_info_book(".$row['id'].")'>
                <div class='book_image' style='background-image: url(".$row['img_url'].")'></div><!--
             --><div class='book_text'>
                    <p class='book_title'>".$row['titolo']."</p>
                    ".$row['autore']."
                </div>
          </div>
          ";
        }
        ?>

        <div class="book_container" pippo="ciao">
            <div class="book_image" style="background-image: url(https://images-na.ssl-images-amazon.com/images/I/51V%2Bb2rUV3L._SX356_BO1,204,203,200_.jpg)"></div><!--
         --><div class="book_text">
                <p class="book_title">La mia casa è dove sono</p>
                Giovannino
            </div>
        </div>
    </div></div>

<!--
New book aside menu
-->

<div id="new_menu" style="left: 100%">
    <form action="script.php" method="post">
        <div id="new_menu_img" class="book_image"></div>
        <h1>Nuovo libro</h1>
        <input type="number" placeholder="ISBN" name="isbn">
        <input type="text" placeholder="Titolo" name="titolo" required>
        <input type="text" placeholder="Autore" name="autore" required>
        <textarea rows="4" cols="50" placeholder="Descrizione" name="descr" ></textarea>
        <input type="text" placeholder="Url immagine" name="img_url" required>
        <h2>Dove si trova?</h2>
        Libreria:
        <select name="nome_libreria" onchange="listalibrerie()">
            <option></option>
            <?php
            $sql = "SELECT * FROM libreria WHERE id_utente = '$id_utente'";
            $result = mysqli_query($conn, $sql);

            while($row = mysqli_fetch_assoc($result)){
                echo "
              <option value='".$row['nome']."'>".$row['nome']."</option>
              ";
            }
            ?>
        </select>
        <script>
            var libreria = {};
            <?php
            $sql = "SELECT * FROM libreria WHERE id_utente = '$id_utente'";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)){
            echo "
            libreria['".$row['nome']."'] = ".$row['n_scaffali'].";
            ";
            }
            ?>
        </script>
        Scaffale:
        <select name="scaffale">
            <option></option>
        </select>
        <input type="submit" value="aggiungi">
        <input type="reset" value="annulla" onclick="slide_new_menu()">
    </form>
</div>

<!--
Info book aside menu
-->

<div id="info_menu" style="left: 100%">
    <img id="loading" src="../imgs/loading.svg" alt="loading.." width="120" height="120">
</div>



<script src="nuovolibro.js"></script>
</body>
</html>
