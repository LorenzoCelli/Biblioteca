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
  <title>Biblioteca - Amici</title>
  <link rel="stylesheet" type="text/css" href="/opensans/opensans.css">
  <link rel="stylesheet" type="text/css" href="/libri/libri2.css">
  <link rel="stylesheet" type="text/css" href="/amici/amici.css">
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
    <a href="/libri/"><button>La mia biblioteca</button></a>
    <a href="/librerie/"><button>Le mie librerie</button></a>
    <a href=""><button disabled>I miei amici</button></a>
    <a href=""><button>I miei prestiti</button></a>
  </div><!--
  --><div class="content">
  <div class="notifica">3</div>
  <div style="border-radius:0 10px 10px 0;height:50px;width:50px;position:absolute;top:20px;left:0;background-color: #f8f8f8; display:inline-block"><img onclick="slide_main_menu()" src="../imgs/menu.svg" style="height: 50px"></div>

  <!--
  |--------------------------------------------------------------|
  |  Menu volante account                                        |
  |--------------------------------------------------------------|
  -->
  <div id="menu_volante_account" class="menu_volante">
    <div>Richieste d'amicizia:</div>
    <div style="background-color:white;">
      <img src="/imgs/avatars/1.png">
      <p style="">asd</p>
      <button class="accetta_rifiuta" style="height:30px;border-bottom:0px;" onclick="accetta_rifiuta(1,&quot;0&quot;,this)">Rifiuta</button>
      <button class="accetta_rifiuta" style="height:30px;border-bottom:0px;" onclick="accetta_rifiuta(1,&quot;1&quot;,this)">Accetta</button>
    </div>
    <div style="background-color:white;">
      <img src="/imgs/avatars/1.png">
      <p style="">asd</p>
      <button class="accetta_rifiuta" style="height:30px;border-bottom:0px;" onclick="accetta_rifiuta(1,&quot;0&quot;,this)">Rifiuta</button>
      <button class="accetta_rifiuta" style="height:30px;border-bottom:0px;" onclick="accetta_rifiuta(1,&quot;1&quot;,this)">Accetta</button>
    </div>
    <div style="background-color:white;">
      <img src="/imgs/avatars/1.png">
      <p style="">asd</p>
      <button class="accetta_rifiuta" style="height:30px;border-bottom:0px;" onclick="accetta_rifiuta(1,&quot;0&quot;,this)">Rifiuta</button>
      <button class="accetta_rifiuta" style="height:30px;border-bottom:0px;" onclick="accetta_rifiuta(1,&quot;1&quot;,this)">Accetta</button>
    </div>
      <div>Il tuo account:</div>
      <button onclick="window.location.href='/account/'">impostazioni</button>
      <button onclick="window.location.href='/logout.php'" style="border: none">logout</button>
  </div>

  <div onclick="apri_menu_volante('account')" class="scatola_account">
      <p><?php echo $uname;?></p>
      <img src=<?php echo $img; ?>>
  </div>
  <div class="scatola_cerca">
      <input id="search_bar" type="text" placeholder="cerca utente" onclick="searchAnimation();"><!--
      --><input type="submit" id="search_button" value="" onclick="ricerca_utenti();">
    <div id="ris_div">

    </div>
  </div>
  <img src="https://png.icons8.com/ios/100/ffffff/circled-chevron-down.png" onclick="dropDown();" class="menu_amici_img">
  <div class="menu_amici">
    <div class="opzione_menu" onclick="menuScelto('scatola_amici','scatola_biblioteca')">Amici</div>
    <div class="opzione_menu" onclick="menuScelto('scatola_biblioteca','scatola_amici')">Biblioteche preferite</div>
  </div>
  <div class="scatola_amici">
    <h1 class="title">Amici</h1>

    <?php
    $sql = "SELECT * FROM amici
    INNER JOIN utenti
    ON amici.id_amico = utenti.id OR amici.id_utente = utenti.id
    WHERE amici.accettato = 1
    AND utenti.id != '$id_utente'
    AND (amici.id_utente = '$id_utente'
    OR amici.id_amico = '$id_utente')";
    $results = mysqli_query($conn, $sql);
    if ($results->num_rows == 0) {
      echo "<p id='no_amici'>Non hai ancora aggiunto nessun amico!</p>";
    }else{
      while ($row = mysqli_fetch_assoc($results)) {
        $uname_amico = $row['username'];
        $avatar_amico = $row['id_avatar'];
        $img_avatar = avatar($avatar_amico);
        echo "
        <div class='scheda_utente'>
        <img src='$img_avatar'>
        <p style='display:inline-block;'>$uname_amico</p>
        </div>
        ";
      }
    }
    ?>
    <div class='scheda_utente'>
    <img src="/imgs/avatars/2.png">
    <p style='display:inline-block;'>$uname_amico</p>
    </div>
    <div class='scheda_utente'>
    <img src="/imgs/avatars/3.png">
    <p style='display:inline-block;'>$uname_amico</p>
    </div>
    <div class='scheda_utente'>
    <img src="/imgs/avatars/4.png">
    <p style='display:inline-block;'>$uname_amico</p>
    </div>
    <div class='scheda_utente'>
    <img src="/imgs/avatars/5.png">
    <p style='display:inline-block;'>$uname_amico</p>
    </div>
    <div class='scheda_utente'>
    <img src="/imgs/avatars/6.png">
    <p style='display:inline-block;'>$uname_amico</p>
    </div>
    <div class='scheda_utente'>
    <img src="/imgs/avatars/1.png">
    <p style='display:inline-block;'>$uname_amico</p>
    </div>
    <div class='scheda_utente'>
    <img src="/imgs/avatars/2.png">
    <p style='display:inline-block;'>$uname_amico</p>
    </div>
    <div class='scheda_utente'>
    <img src="/imgs/avatars/3.png">
    <p style='display:inline-block;'>$uname_amico</p>
    </div>
    <div class='scheda_utente'>
    <img src="/imgs/avatars/4.png">
    <p style='display:inline-block;'>$uname_amico</p>
    </div>
    <div class='scheda_utente'>
    <img src="/imgs/avatars/5.png">
    <p style='display:inline-block;'>$uname_amico</p>
    </div>
    <div class='scheda_utente'>
    <img src="/imgs/avatars/6.png">
    <p style='display:inline-block;'>$uname_amico</p>
    </div>
    <div class='scheda_utente'>
    <img src="/imgs/avatars/1.png">
    <p style='display:inline-block;'>$uname_amico</p>
    </div>
  </div>

  <div class="scatola_biblioteca">
    <h1 class="title">Biblioteche</h1>
    <div class="contenitore_biblioteche">
      <p style="color:black; display:none;">Nessuna biblioteca preferita</p>
      <button type="button" style="width:85%;background-color:#292929;color:white;display:none;">Aggiungi biblioteca</button>
      <div class="scheda_biblioteche">
        <img src="/imgs/avatars/1.png">
        <p style="display:inline-block;">biblioteca di @cellino</p>
      </div>
      <div class="scheda_biblioteche">
        <img src="/imgs/avatars/2.png">
        <p style="display:inline-block;">biblioteca di @cellino</p>
      </div>
      <div class="scheda_biblioteche">
        <img src="/imgs/avatars/3.png">
        <p style="display:inline-block;">biblioteca di @cellino</p>
      </div>
      <div class="scheda_biblioteche">
        <img src="/imgs/avatars/4.png">
        <p style="display:inline-block;">biblioteca di @cellino</p>
      </div>
      <div class="scheda_biblioteche">
        <img src="/imgs/avatars/5.png">
        <p style="display:inline-block;">biblioteca di @cellino</p>
      </div>
      <div class="scheda_biblioteche">
        <img src="/imgs/avatars/6.png">
        <p style="display:inline-block;">biblioteca di @cellino</p>
      </div>
    </div>
  </div>

</div>
</div>

<script src="/libri/comune.js"></script>
<script src="/libri/libri.js"></script>
<script src="/amici/amici.js"></script>
</body>
</html>
