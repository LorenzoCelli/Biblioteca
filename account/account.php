<?php session_start();
$uname = $_SESSION['uname'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La tua biblioteca</title>
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
          <div style="display: inline-block; height: 50px; width: 50px; overflow: hidden"><img src="../imgs/usericon.svg" alt="icona_utente_non_trovata" style="width:50px;height:50px;"></div>
        </div></a>
        <div id="menu_account" style="background-color:white;">
            <p class="account_menu_header">Il tuo account</p>
            <a href=""><button class="account_button">Impostazioni</button></a>
            <button style="border-bottom: none;border-radius:0 0 10px 10px;" class="account_button">Logout</button>
        </div>
    </div></div>

<script src="../main/main.js"></script>
</body>
</html>
