<?php session_start();
$uname = $_SESSION['uname'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La tua biblioteca</title>
    <link rel="stylesheet" type="text/css" href="/libri/libri.css">
    <link href="https://fonts.googleapis.com/css?family=Vollkorn:400,600,900" rel="stylesheet">
    <link href="/opensans/opensans.css" rel="stylesheet">
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
        <a href=""><button disabled>La mia biblioteca</button></a>
        <a href="../librerie/index.php"><button>Le mie librerie</button></a>
        <a href=""><button>I miei amici</button></a>
        <a href=""><button>Tua sorella</button></a>
    </div><!--
 --><div class="content">
        <div id="menu_ordina">
            <button style="height: 30px" disabled>ordina per:</button>
            <button>nome</button>
            <button>autore</button>
            <button style="border-bottom: none">genere</button>
        </div>

        <div style="border-radius: 0 10px 10px 0; height: 50px; width:50px; position: absolute; top:20px; left: 0; background-color: #f8f8f8; display: inline-block"><img onclick="slide_main_menu()" src="../imgs/menu.svg" style="height: 50px"></div>
        <a onclick="show_menu_account()"><div class="scatola_account">
          <p2 id="nome_utente"><?php echo $uname;?></p2>
          <div style="display: inline-block; height: 50px; width: 50px; overflow: hidden"><img src="../imgs/usericon.svg" alt="icona_utente_non_trovata" style="width:50px;height:50px;"></div>
        </div></a>
        <div id="menu_account">
            <button class="account_button" disabled>Il tuo account</button>
            <a href="../account/account.php"><button class="account_button">Impostazioni</button></a>
            <button style="border-bottom: none" class="account_button">Logout</button>
        </div>

        <h1 style="color: white; margin: 0; line-height: 30px"> La tua biblioteca. </h1>

        <div class="barra_bottoni"><!--
         --><div onclick="slide_new_menu()"><img src="../imgs/piu.svg"></div><!--
         --><div onclick="show_little_menu()"><img src="../imgs/ordina.svg"></div><!--
         --><div onclick="slide_search_bar()"><img src="../imgs/lente.svg"></div><!--
         --><input id="search_bar" class="menu_input" type="text"></div>
        <br>

        <?php

        $id_utente = $_SESSION['id_utente'];

        include '../connection.php';

        $sql = "SELECT * FROM libri WHERE id_utente = '$id_utente'";
        $result = mysqli_query($conn, $sql);

        while($row = mysqli_fetch_assoc($result)){
          echo "
          <div class='pillola_libro' onclick='info_libro(".$row['id'].")'>
                <div class='immagine_pillola_libro' style='background-image: url(".$row['img_url'].")'></div><!--
             --><div class='testo_pillola_libro'>
                    <p class='titolo_pillola_libro'>".$row['titolo']."</p>
                    ".$row['autore']."
                </div>
          </div>
          ";
        }
        ?>

        <div class="pillola_libro">
            <div class="immagine_pillola_libro" style="background-image: url(https://images-na.ssl-images-amazon.com/images/I/51V%2Bb2rUV3L._SX356_BO1,204,203,200_.jpg)"></div><!--
         --><div class="testo_pillola_libro">
                <p class="titolo_pillola_libro">La mia casa è dove sono</p>
                Giovannino
            </div>
        </div>
    </div></div>

<!--
|--------------------------------------------------------------|
|                                                              |
|  Menu nuovo libro                                            |
|                                                              |
|--------------------------------------------------------------|
-->

<div id="menu_aggiungi" style="left: 100%">
        <div id="img_aggiungi" class="immagine_pillola_libro"></div>
        <h1>Nuovo libro</h1>
        <div class="scatola_aggiungi"><!--
         --><input type="number" placeholder="ISBN" name="isbn"><!--
         --><div id="isbn_menu_options"></div></div>

        <div class="scatola_aggiungi"><!--
         --><input type="text" placeholder="Titolo" name="titolo" required><!--
         --><div id="title_menu_options"></div></div>

        <div class="scatola_aggiungi"><!--
         --><input type="text" placeholder="Autore" name="autore" required><!--
         --><div id="author_menu_options"></div></div>

        Generi: <br>
        <div id="generi"><div class="pillola_genere" contenteditable="true"><img onclick="nuovo_genere(this)" src="../imgs/piu_pillola.svg"></div></div>

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
        <button onclick="nuovo_libro(this)">aggiungi</button>
        <input type="reset" value="annulla" onclick="slide_new_menu()">
</div>

<!--
|--------------------------------------------------------------|
|                                                              |
|  Menu info libro                                             |
|                                                              |
|--------------------------------------------------------------|
-->

<div id="menu_info" style="left: 100%">
</div>

<script src="/libri/comune.js"></script>
<script src="/libri/libri.js"></script>
</body>
</html>