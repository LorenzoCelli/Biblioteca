<?php session_start();
include "../connection.php";
$uname = $_SESSION['uname'];
$id_utente = $_SESSION['id_utente'];
$sql = "SELECT * FROM utenti WHERE id = '$id_utente'";
$results = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($results);
$id_avatar = $row['id_avatar'];
include '../scriptusericon.php';
$img = avatar($id_avatar);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La tua biblioteca</title>
    <link rel="stylesheet" type="text/css" href="main.css">
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
        <a href="../amici/amici.php"><button class="main_menu_button">I miei amici</button></a>
        <a href=""><button class="main_menu_button">Tua sorella</button></a>
    </div><!--
 --><div class="content">
        <div id="little_menu_box">
            <button class="little_menu_button" style="height: 30px" disabled>ordina per:</button>
            <button class="little_menu_button">nome</button>
            <button class="little_menu_button">autore</button>
            <button style="border-bottom: none" class="little_menu_button">genere</button>
        </div>

        <div style="border-radius: 0 10px 10px 0; height: 50px; width:50px; position: absolute; top:20px; left: 0; background-color: #f8f8f8; display: inline-block"><img onclick="slide_main_menu()" src="../imgs/menu.svg" style="height: 50px"></div>
        <a onclick="show_menu_account()"><div class="account_container">
          <p2 id="nome_utente"><?php echo $uname;?></p2>
          <div style="display: inline-block; height: 50px; width: 50px; overflow: hidden"><img src=<?php echo $img; ?> alt="icona_utente_non_trovata" style="width:50px;height:50px;"></div>
        </div></a>
        <div id="menu_account">
            <button class="account_button" disabled>Il tuo account</button>
            <a href="../account/account.php"><button class="account_button">Impostazioni</button></a>
            <button style="border-bottom: none" class="account_button">Logout</button>
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

        <div class="book_container">
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
        <div id="new_menu_img" class="book_image"></div>
        <h1>Nuovo libro</h1>
        <div class="menu_container"><!--
         --><input type="number" placeholder="ISBN" name="isbn"><!--
         --><div id="isbn_menu_options"></div></div>

        <div class="menu_container"><!--
         --><input type="text" placeholder="Titolo" name="titolo" required><!--
         --><div id="title_menu_options"></div></div>

        <div class="menu_container"><!--
         --><input type="text" placeholder="Autore" name="autore" required><!--
         --><div id="author_menu_options"></div></div>

        Generi: <br>
        <div id="generi"><div class="genere_box" contenteditable="true"><img onclick="nuovo_genere(this)" src="../imgs/piu_pillola.svg"></div></div>

        <textarea rows="4" cols="50" placeholder="Descrizione" name="descr" ></textarea>
        <input type="text" placeholder="Url immagine" name="img_url" required>
        <h2>Dove si trova?</h2>
        Libreria:
        <select name="nome_libreria" onchange="scaffali(this, this.parentElement.querySelector('select[name=scaffale]'))">
            <option value="">Nessuna</option>
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
        <button onclick="new_book(this)">aggiungi</button>
        <input type="reset" value="annulla" onclick="slide_new_menu()">
</div>

<!--
Info book aside menu
-->

<div id="info_menu" style="left: 100%">
</div>


<script src="animazioni.js"></script>
<script src="main.js"></script>
</body>
</html>
