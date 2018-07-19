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
        <a href="/libri/"><button disabled>La mia biblioteca</button></a>
        <a href="/librerie/"><button>Le mie librerie</button></a>
        <a href="/amici/"><button>I miei amici</button></a>
        <a href=""><button>I miei prestiti</button></a>
    </div><!--
 --><div class="content">

        <div style="border-radius: 0 10px 10px 0; height: 50px; width:50px; position: absolute; top:20px; left: 0; background-color: #f8f8f8; display: inline-block"><img onclick="slide_main_menu()" src="../imgs/menu.svg" style="height: 50px"></div>

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

        <div id="risultato_cambio_avatar"></div><br>

        <div class="scatola_avatar">
          <img src="<?php echo $img; ?>" alt="" id="big_icon">
          <button onclick="mostra_avatars();">Cambia avatar</button>
        </div>

        <div id="avatars" style="display:none;">
          <h1>Scegli il tuo avatar:</h1>
          <img src="../imgs/avatars/1.png" alt="1" onclick="change_avatar(this);">
          <img src="../imgs/avatars/2.png" alt="2" onclick="change_avatar(this);">
          <img src="../imgs/avatars/3.png" alt="3" onclick="change_avatar(this);">
          <img src="../imgs/avatars/4.png" alt="4" onclick="change_avatar(this);">
          <img src="../imgs/avatars/5.png" alt="5" onclick="change_avatar(this);">
          <img src="../imgs/avatars/6.png" alt="6" onclick="change_avatar(this);">
          <br><button onclick="update_avatar();">Salva</button>
        </div>

    </div>
</div>

<script src="/libri/libri.js"></script>
<script src="/libri/comune.js"></script>
<script src="account.js"></script>
</body>
</html>
