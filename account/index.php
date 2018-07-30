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
  <title>Biblioteca - Impostazioni</title>
  <link rel="stylesheet" type="text/css" href="../opensans/opensans.css">
  <link rel="stylesheet" type="text/css" href="/libri/libri.css">
  <link rel="stylesheet" type="text/css" href="account.css">
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
    <a href="/amici/"><button>I miei amici</button></a>
    <a href=""><button>I miei prestiti</button></a>
  </div><!--
  --><div class="content">

        <div class="tasto_menu"><img onclick="chiama_menu_principe()" src="../imgs/menu.svg"></div>

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
  <img src=<?php echo $img; ?> id="small_icon">
</div>
<h1 style="color: white; margin-bottom: 10px; line-height: 30px">Impostazioni account</h1>
<div class="scatola_tutto">
  <div class="scatola_informazioni">
    <div class="scatola_avatar">
      <img src="<?php echo $img; ?>" alt="" id="big_icon">
      <button onclick="mostra_avatars();">Cambia avatar</button>
    </div><!--
    --><div class="scatola_informazioni_dati">
    <p class="titolo_informazioni" id="title">Username: </p><p id="pinfo">botti112</p><br>
    <p class="titolo_informazioni">Email: </p><p id="pinfo">botti@gmail.com</p><br>
    <p class="titolo_informazioni">Libri totali: </p><p id="pinfo">24</p><br>
    <p class="titolo_informazioni">Librerie: </p><p id="pinfo">12</p><br>
    <p class="titolo_informazioni">Libri letti: </p><p id="pinfo">4</p><br>
  </div>
</div>
<div id="avatars" style="overflow:hidden;">
  <h1>Scegli il tuo avatar:</h1>
  <?php
  for ($i=1; $i < 10; $i++) {
    echo "<img src='".avatar($i)."' alt='$i' onclick='change_avatar(this);'>";
  }
  ?>
  <br><button onclick="update_avatar();">Salva</button>
</div>
</div>
<div class="scatola_pulsanti">
  <div>
    <button type="button" onclick="animazionePulsanti(this,180)">Cambia sfondo</button>
    <div class="contenitore_sfondo">
      <h4 style="background-color: #fa643f;">Scegli sfondo</h4>
      <h5>Colori:</h5>
      <div style="background-color:Tomato;"></div>
      <div style="background-color:Orange;"></div>
      <div style="background-color:DodgerBlue;"></div>
      <div style="background-color:MediumSeaGreen;"></div>
      <div style="background-color:Gray;"></div>
      <div style="background-color:SlateBlue;"></div>
      <div style="background-color:Violet;"></div>
      <div style="background-color:LightGray;"></div>
      <button type="button">Annulla</button>
      <button type="button">Salva</button>
    </div>
  </div>
  <button type="button" id="username" onclick="animazionePulsanti(this,180)">Cambia username</button>
  <div>
    <div class="contenitore_username">
      <h4 style="background-color: Orange;">Scegli nuovo username</h4>
      <h5>Username:</h5>
      <input type="text" placeholder="Inserisci username">
      <button type="button">Annulla</button>
      <button type="button">Salva</button>
    </div>
  </div>
  <div>
    <button type="button" id="password" onclick="animazionePulsanti(this,125)">Cambia password</button>
    <div class="contenitore_password">
      <h4 style="background-color: DodgerBlue;">Ti invieremo un email per cambiare la password</h4>
      <button type="button">Annulla</button>
      <button type="button">Conferma</button>
    </div>
  </div>
  <div>
    <button type="button" id="email" onclick="animazionePulsanti(this,265)">Cambia email</button>
    <div class="contenitore_email">
      <h4 style="background-color: #4bb369;">Scegli nuova email</h4>
      <h5>Email nuova:</h5>
      <input type="text" placeholder="Inserisci email nuova">
      <h5>Email nuova conferma:</h5>
      <input type="text" placeholder="Conferma email nuova">
      <button type="button">Annulla</button>
      <button type="button">Salva</button>
    </div>
  </div>
</div>
<div id="risultato_cambio_avatar"></div><br>
</div>
</div>


<script src="/libri/comune.js"></script>
<script src="account.js"></script>
</body>
</html>
