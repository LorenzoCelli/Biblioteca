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
    <a href="/libri/"><button>Biblioteca</button></a>
    <a href="/librerie/"><button>Librerie</button></a>
    <a href=""><button disabled>Amici</button></a>
    <a href="/prestiti/"><button>Prestiti</button></a>
    <a href="/messaggi/"><button>Messaggi</button></a>
  </div><!--
  --><div class="content">

  <div style="border-radius:0 10px 10px 0;height:50px;width:50px;position:absolute;top:20px;left:0;background-color: #f8f8f8; display:inline-block"><img onclick="chiama_menu_principe()" src="../imgs/menu.svg" style="height: 50px"></div>

  <!--
  |--------------------------------------------------------------|
  |  Menu volante account                                        |
  |--------------------------------------------------------------|
  -->
  <div id="menu_volante_account" class="menu_volante" style="overflow:hidden;">
    <?php
    $sql = "SELECT * FROM amici
    INNER JOIN utenti
    ON amici.id_utente = utenti.id
    WHERE amici.accettato = 0
    AND amici.id_amico = '$id_utente'";
    $results = mysqli_query($conn, $sql);
    $n_notifiche = $results->num_rows;
    if ($results->num_rows == 0) {
    }else{
      echo "<div>Richieste d'amicizia:</div>";
      while ($row = mysqli_fetch_assoc($results)) {
        $id_utente_amico = $row['id_utente'];
        $uname_amico = $row['username'];
        $avatar_amico = $row['id_avatar'];
        $img_avatar = avatar($avatar_amico);
        echo "
        <div style='background-color:white;' onclick='visita_profilo($id_utente_amico,\"$uname_amico\")'>
          <img src='$img_avatar'>
          <p style='display:inline-block;'>$uname_amico</p>
          <button class='accetta_rifiuta' style='height:30px;border-bottom:0px;' onclick='accetta_rifiuta($id_utente_amico,\"0\",this)'>Rifiuta</button>
          <button class='accetta_rifiuta' style='height:30px;border-bottom:0px;' onclick='accetta_rifiuta($id_utente_amico,\"1\",this)'>Accetta</button>
        </div>
        ";
      }
    }
    ?>
    <div>Il tuo account:</div>
    <button onclick="window.location.href='/account/'">impostazioni</button>
    <button onclick="window.location.href='/logout.php'" style="border:none">logout</button>
  </div>

  <?php
  if ($n_notifiche != 0) {
    echo "<div class='notifica'>$n_notifiche</div>";
  }
  ?>
  <div onclick="apri_menu_volante('account');nascondi_notifiche();" class="scatola_account">
      <p><?php echo $uname;?></p>
      <img src=<?php echo $img;?>>
  </div>
  <div class="scatola_cerca">
      <input id="barra_ricerca" type="text" placeholder="cerca utente" onclick="searchAnimation();"><!--
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
    $sql = "SELECT utenti.id id_utente_amico,username,email,id_avatar,id_amico,accettato,id_utente FROM amici
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
        $id_profilo = $row['id_utente_amico'];
        $uname_amico = $row['username'];
        $avatar_amico = $row['id_avatar'];
        $img_avatar = avatar($avatar_amico);
        echo "
        <div class='scheda_utente' onclick='visita_profilo($id_profilo,\"$uname_amico\")'>
        <img src='$img_avatar'>
        <p style='display:inline-block;'>$uname_amico</p>
        </div>
        ";
      }
    }
    ?>
  </div>

  <div class="scatola_biblioteca">
    <h1 class="title">Biblioteche</h1>
    <div class="contenitore_biblioteche">
      <?php
      $sql = "SELECT * FROM preferiti
      INNER JOIN utenti
      ON preferiti.id_biblioteca = utenti.id
      WHERE preferiti.id_utente = $id_utente";
      $results = mysqli_query($conn, $sql);
      while ($row = mysqli_fetch_assoc($results)) {
        $id_profilo = $row['id'];
        $uname_pref = $row['username'];
        $avatar_amico = $row['id_avatar'];
        $img_avatar = avatar($avatar_amico);
        echo "
        <div class='scheda_biblioteche' onclick='visita_profilo($id_profilo,\"$uname_pref\")'>
          <img src='$img_avatar'>
          <p style='display:inline-block;'>biblioteca di $uname_pref</p>
        </div>
        ";
      }
      ?>
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
