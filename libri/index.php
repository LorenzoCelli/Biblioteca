<?php session_start();
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';
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
    <title>Biblioteca - Libri</title>
    <link rel="stylesheet" type="text/css" href="/opensans/opensans.css" >
    <link rel="stylesheet" type="text/css" href="/libri/libri.css">
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
        <a href=""><button disabled>La mia biblioteca</button></a>
        <a href="../librerie/index.php"><button>Le mie librerie</button></a>
        <a href="/amici/"><button>I miei amici</button></a>
        <a href=""><button>I miei prestiti</button></a>
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

        <h1 style="color: white; margin: 0; line-height: 30px"> La tua biblioteca. </h1>

        <div class="barra_bottoni"><!--
         --><div onclick="chiama_menu_aggiungi()"><img src="/imgs/piu.svg"></div><!--
         --><div onclick="espandi_pillole()"><img src="/imgs/occhio.svg"></div><!--
         --><div onclick="apri_menu_volante('ordina')"><img src="/imgs/ordina.svg"></div><!--
         --><div onclick="chiama_barra_ricerca()"><img src="/imgs/lente.svg"></div><!--
         --><input id="search_bar" class="menu_input" type="text"></div>
        <br>

        <div id="pillole_libro">
        <?php

        $sql = "SELECT * FROM libri WHERE id_utente = '$id_utente'";
        $result = mysqli_query($conn, $sql);

        if ($result->num_rows == 0) {
          echo "<p>Non hai ancora aggiunto libri alla tua biblioteca, fallo ora!</p>";
        }else{
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
        }
        ?>
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

        <div id="img_aggiungi" style="background-image: url('/imgs/librosconosciuto.svg')" class="immagine_pillola_libro"></div>
        <h1>Nuovo libro</h1>

        <div class="scatola_suggerimenti"><!--
         --><div id="finestra_scan"></div><!--
         --><div class="input_con_immagine"><input type="text" placeholder="ISBN" name="isbn"><img onclick="mostra_scanner()" src="/imgs/foto.svg"></div><!--
         --><div id="isbn_menu_options"></div></div>

        <div class="scatola_suggerimenti"><!--
         --><input type="text" placeholder="Titolo" name="titolo" required><!--
         --><div id="title_menu_options"></div></div>

        <div class="scatola_suggerimenti"><!--
         --><input type="text" placeholder="Autore" name="autore" required><!--
         --><div id="author_menu_options"></div></div>

        Generi: <br>
        <div id="generi"><div class="pillola_genere" contenteditable="true"><img onclick="nuovo_genere(this)" src="../imgs/piu_pillola.svg"></div></div>

        <textarea rows="4" cols="50" placeholder="Descrizione" name="descr" ></textarea>
        <input type="text" placeholder="Url immagine" name="img_url" required>
        <h2>Dove si trova?</h2>
        Libreria:
        <select name="nome_libreria" onchange="scaffali(this, this.parentElement.querySelector('select[name=scaffale]'))">
            <option value="nessuna">Nessuna</option>
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
        <button onclick="azzera_menu_aggiungi()">annulla</button>
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


<script src="/quaggaJS/quagga.js"></script>
<script src="/libri/comune.js"></script>
<script src="/libri/libri.js"></script>
</body>
</html>
