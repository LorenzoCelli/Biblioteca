<?php session_start();
include "../connection.php";
$uname = $_SESSION['uname'];
$id_utente = $_SESSION['id_utente'];
$sql = "SELECT * FROM utenti WHERE id = '$id_utente'";
$results = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($results);
$id_avatar = $row['id_avatar'];
include 'scriptusericon.php';
$img = avatar($id_avatar);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Biblioteca - Amici</title>
  <link rel="stylesheet" type="text/css" href="../main/main.css">
  <link rel="stylesheet" type="text/css" href="amici.css">
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
  <div style="border-radius: 0 10px 10px 0; height: 50px; width:50px; position: absolute; top:20px; left: 0; background-color: #f8f8f8; display: inline-block"><img onclick="slide_main_menu()" src="../imgs/menu.svg" style="height: 50px"></div>
  <a onclick="show_menu_account()"><div class="account_container">
    <p2 id="nome_utente"><?php echo $uname;?></p2>
    <div style="display: inline-block; height: 50px; width: 50px; overflow: hidden"><img id="small_icon" src="<?php echo $img; ?>" alt="icona_utente_non_trovata" style="width:50px;height:50px;"></div>
  </div></a>
  <div id="menu_account" style="background-color:white;">
    <p class="account_menu_header">Il tuo account</p>
    <a href=""><button class="account_button">Impostazioni</button></a>
    <button style="border-bottom: none;border-radius:0 0 10px 10px;" class="account_button">Logout</button>
  </div>

  <h1 style="margin-top:0;">Trova un utente:</h1>
  <div style="display:inline-block;">
    <input id="search_bar" type="text"><!--
    --><input type="submit" id="search_button" value="" onclick="ricerca_utenti();">
  </div>

  <div id="ris_div" style="padding:20px;">

  </div>

  <h1>Lista amici</h1>

  <div style="padding:20px;">
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
      <a><div style='display:block;cursor:pointer;margin-right:10px;'>
      <div style='display: inline-block; height: 50px; width: 50px; overflow: hidden'><img id='small_icon' src='$img_avatar' style='width:50px;height:50px;'></div>
      <p2 id='nome_utente'>$uname_amico</p2>
      </div></a>
      ";
    }
  }
  ?>
  </div>

  <h1>Biblioteche preferite</h1>

</div></div>

<script src="../main/main.js"></script>
<script src="../main/animazioni.js"></script>
<script src="amici.js"></script>
</body>
</html>
