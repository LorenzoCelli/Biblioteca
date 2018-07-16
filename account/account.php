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
    <title>Biblioteca - Impostazioni</title>
    <link rel="stylesheet" type="text/css" href="../main/main.css">
    <link rel="stylesheet" type="text/css" href="account.css">
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

        <div id="change_div"></div><br>
        <div class="" style="position:relative;width:225px;height:225;display:inline-block;border-radius:100%;">
          <img src="<?php echo $img; ?>" alt="" id="big_icon"><br>
          <button id="avatar_button" onclick="show_avatars();">Cambia avatar</button>
        </div>
        <div id="avatars" style="display:none;">
          <h1>Scegli il tuo avatar:</h1>
          <img src="../imgs/avatars/1.png" alt="1" class="scelta" onclick="change_avatar(this);">
          <img src="../imgs/avatars/2.png" alt="2" class="scelta" onclick="change_avatar(this);">
          <img src="../imgs/avatars/3.png" alt="3" class="scelta" onclick="change_avatar(this);">
          <img src="../imgs/avatars/4.png" alt="4" class="scelta" onclick="change_avatar(this);">
          <img src="../imgs/avatars/5.png" alt="5" class="scelta" onclick="change_avatar(this);">
          <img src="../imgs/avatars/6.png" alt="6" class="scelta" onclick="change_avatar(this);">
          <br><input type="submit" onclick="update_avatar();" value="Salva" style="width:70px;padding:10px;">
        </div>

    </div></div>

<script src="../main/main.js"></script>
<script src="../main/animazioni.js"></script>
<script src="account.js"></script>
</body>
</html>
