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
    <h1>Contatti:</h1>
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
      echo "<p id='no_amici'>Aggiungi amici per messaggiare</p>";
    }else{
      while ($row = mysqli_fetch_assoc($results)) {
        $id_amico = $row['id'];
        $uname_amico = $row['username'];
        $avatar_amico = $row['id_avatar'];
        $img_avatar = avatar($avatar_amico);
        echo "
        <div class='contatti' onclick='mostra_messaggi($id_amico,\"$uname_amico\");'>
          <img src='$img_avatar'>
          <p>$uname_amico</p>
        </div>
        ";
      }
    }
    ?>
  </aside>
</div><!--
--><div class="scatola_chat">
  <h1 id="amico_msg">Gino</h1>
  <div id="scatola_messaggi">
    <div class="messaggio" style="text-align:right">
      <div>
        <p style="margin-right:40px;">Ciao Gino</p>
        <i>18:00</i>
      </div>
    </div>
    <div class="messaggio" style="text-align:left">
      <div>
        <p style="margin-left:30px;">Ciao Denis</p>
      </div>
    </div>
    <div class="messaggio" style="text-align:right">
      <div>Come sta Ale?</div>
    </div>
    <div class="messaggio" style="text-align:left">
      <div>Bene</div>
    </div>
  </div>
  <footer>
    <textarea id="testo" placeholder="Invia un messaggio..."></textarea>
    <button onclick="invia_messaggio()">INVIA</button>
  </footer>
</div>

</div></div>


<script src="/libri/comune.js"></script>
<script src="/libri/libri.js"></script>
<script src="/messaggi/messaggi.js"></script>
</body>
</html>
