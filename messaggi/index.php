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
  <title>Biblioteca - Messaggi</title>
  <link rel="stylesheet" type="text/css" href="/opensans/opensans.css">
  <link rel="stylesheet" type="text/css" href="/libri/libri.css">
  <link rel="stylesheet" type="text/css" href="/messaggi/messaggi.css">
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
    <a href=""><button disabled>I miei prestiti</button></a>
  </div><!--
  --><div class="content">

  <div style="border-radius:0 10px 10px 0;height:50px;width:50px;position:absolute;top:20px;left:0;background-color: #f8f8f8; display:inline-block"><img onclick="chiama_menu_principe()" src="../imgs/menu.svg" style="height: 50px"></div>

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

<div class="scatola_contatti">
  <aside>
    Gino<br>
    Denis<br>
    Bruno<br>
  </aside>
</div><!--
--><div class="scatola_chat">
  <h1>Gino</h1>
  <footer>
    <textarea name="msg" placeholder="Invia un messaggio..."></textarea>
    <button>INVIA</button>
  </footer>
</div>

</div></div>


<script src="/libri/comune.js"></script>
<script src="/libri/libri.js"></script>
<script src="/messaggi/messaggi.js"></script>
</body>
</html>
