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
  <link rel="stylesheet" type="text/css" href="/libri/libri.css">
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

  <div style="border-radius:0 10px 10px 0;height:50px;width:50px;position:absolute;top:20px;left:0;background-color: #f8f8f8; display:inline-block"><img onclick="slide_main_menu()" src="../imgs/menu.svg" style="height: 50px"></div>

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

  <div onclick="apri_menu_volante('account')" class="scatola_account">
      <p><?php echo $uname;?></p>
      <img src=<?php echo $img; ?>>
  </div>

  <?php
  $sql = "SELECT * FROM amici
  INNER JOIN utenti ON amici.id_utente = utenti.id
  WHERE amici.accettato = 0 AND amici.id_amico = '$id_utente'";
  $results = mysqli_query($conn, $sql);
  if ($results->num_rows != 0) {
    echo "
    <div style='display:block;margin:0 0 10px 0;'>
    <h1>Richieste d'amicizia:</h1>
    ";
    while ($row = mysqli_fetch_assoc($results)) {
      $id_amico = $row['id'];
      $uname_amico = $row['username'];
      $avatar_amico = $row['id_avatar'];
      $img_avatar = avatar($avatar_amico);
      echo "
      <div class='scheda_utente' style='width:400px;'>
        <img src='$img_avatar'>
        <p style=''>$uname_amico</p>
        <button class='accetta_rifiuta' onclick='accetta_rifiuta($id_amico,\"0\",this)'>Rifiuta</button>
        <button class='accetta_rifiuta' onclick='accetta_rifiuta($id_amico,\"1\",this)'>Accetta</button>
      </div>
      ";
    }
    echo "</div>";
  }
  ?>

  <div class="scatola_liste">
    <h1 style="margin-top:0;">Trova un utente:</h1>
    <div style="display:inline-block;padding:20px 0">
      <input id="search_bar" type="text"><!--
      --><input type="submit" id="search_button" value="" onclick="ricerca_utenti();">
    </div>

    <div id="ris_div" style="padding:20px 0;overflow:hidden;">

    </div>
  </div>

  <div class="scatola_liste">
    <h1>Lista amici</h1>

    <div style="padding:20px 0;">
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
    </div>

  </div>

  <div class="scatola_liste">
    <h1>Biblioteche preferite</h1>
  </div>

</div></div>

<script src="/libri/comune.js"></script>
<script src="/libri/libri.js"></script>
<script src="/amici/amici.js"></script>
</body>
</html>
