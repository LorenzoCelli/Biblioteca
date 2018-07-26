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
  <title>Biblioteca - Prestiti</title>
  <link rel="stylesheet" type="text/css" href="/opensans/opensans.css">
  <link rel="stylesheet" type="text/css" href="/libri/libri.css">
  <link rel="stylesheet" type="text/css" href="/amici/amici.css">
  <link rel="stylesheet" type="text/css" href="/prestiti/prestiti.css">
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
<img src="https://png.icons8.com/ios/100/ffffff/circled-chevron-down.png" onclick="dropDown();" class="menu_amici_img" style="transform: rotate(90deg); transition: all 0.4s;">
<div class="scatola_cronologia">
<h1 class="title">Prestiti terminati</h1>
<br>
<div class="contenitore_prestati">
  <h3>Ho prestato:</h3>
</div>
<div class="contenitore_prestati">
  <h3>Ho preso in prestito:</h3>
</div>
<?php
$sql = "SELECT * FROM prestiti
INNER JOIN libri ON libri.id = prestiti.id_libro
INNER JOIN utenti ON prestiti.id_creditore = utenti.id OR prestiti.id_debitore = utenti.id
WHERE utenti.id != '$id_utente'
AND (prestiti.id_creditore = '$id_utente' OR prestiti.id_debitore = '$id_utente')
AND data_fine is NOT NULL";
$result = mysqli_query($conn, $sql);
if ($result->num_rows == 0) {
  echo "";
}else{
  while ($row = mysqli_fetch_assoc($result)) {
    date_default_timezone_set('Europe/Rome');
    $timestamp = strtotime($row['data_inizio']);
    $data_inizio = date('d-m-Y', $timestamp);
    $timestamp = strtotime($row['data_promemoria']);
    $data_promemoria = date('d-m-Y', $timestamp);
    echo "
    <div class='pillola_libro'>
    <div class='immagine_pillola_libro' style='background-image: url(".$row['img_url'].")'></div><!--
    --><div class='testo_pillola_libro'>
    <p class='titolo_pillola_libro'><b>".$row['titolo']."</b></p>
    ";
    if ($row['id_creditore'] == $id_utente) {
      echo "
      Libro di <b>".$uname."</b><br>
      prestato a <b>".$row['username']."</b><br>
      il giorno <b>$data_inizio</b><br>
      restituito il <b>$data_fine</b>
      ";
    }else{
      echo "
      Libro di <b>".$row['username']."</b><br>
      prestato a <b>".$uname."</b><br>
      il giorno <b>$data_inizio</b><br>
      restituito il <b>$data_fine</b>
      ";
    }
    echo "</div></div>";
  }
}
?>
</div>
<div class="menu_amici" style="transition: all 0.4s;">
    <div class="opzione_menu" onclick="menuScelto('contenitore_prestiti','scatola_cronologia')">Prestiti in corso</div>
    <div class="opzione_menu" onclick="menuScelto('scatola_cronologia','contenitore_prestiti')">Prestiti terminati</div>
  </div>
<!--
--><div class="contenitore_prestiti">
  <h1 class="title" style="margin-bottom: 0px;">Prestiti in corso</h1>
  <div class="barra_bottoni"><!--
  --><div onclick="chiama_menu_aggiungi()"><img src="../imgs/piu.svg"></div><!--
  --><div onclick="slide_search_bar()"><img src="../imgs/lente.svg"></div><!--
  --><input id="search_bar" class="menu_input" type="text" style="width:0;"></div><br>
  <?php
  $sql = "SELECT * FROM prestiti
  INNER JOIN libri ON libri.id = prestiti.id_libro
  INNER JOIN utenti ON prestiti.id_creditore = utenti.id OR prestiti.id_debitore = utenti.id
  WHERE utenti.id != '$id_utente'
  AND (prestiti.id_creditore = '$id_utente' OR prestiti.id_debitore = '$id_utente')
  AND data_fine is NULL";
  $result = mysqli_query($conn, $sql);
  $results = mysqli_query($conn, $sql);
  ?>
  <div class="contenitore_prestati" style="margin-right:10%;">
    <h3>Ho prestato:</h3>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
      date_default_timezone_set('Europe/Rome');
      $timestamp = strtotime($row['data_inizio']);
      $data_inizio = date('d-m-Y', $timestamp);
      $timestamp = strtotime($row['data_promemoria']);
      $data_promemoria = date('d-m-Y', $timestamp);
      if ($row['id_creditore'] == $id_utente) {
        echo "
        <div class='pillola_libro'>
        <div class='immagine_pillola_libro' style='background-image: url(".$row['img_url'].")'></div><!--
        --><div class='testo_pillola_libro'>
        <p class='titolo_pillola_libro'><b>".$row['titolo']."</b></p>
        Libro di <b>".$uname."</b><br>
        prestato a <b>".$row['username']."</b>
        </div></div>";
      }
    }
    ?>
  </div><!--
  --><div class="contenitore_prestati">
    <h3>Ho preso in prestito:</h3>
    <?php
    while ($row = mysqli_fetch_assoc($results)) {
      date_default_timezone_set('Europe/Rome');
      $timestamp = strtotime($row['data_inizio']);
      $data_inizio = date('d-m-Y', $timestamp);
      $timestamp = strtotime($row['data_promemoria']);
      $data_promemoria = date('d-m-Y', $timestamp);
      if ($row['id_creditore'] != $id_utente) {
        echo "
        <div class='pillola_libro'>
        <div class='immagine_pillola_libro' style='background-image: url(".$row['img_url'].")'></div><!--
        --><div class='testo_pillola_libro'>
        <p class='titolo_pillola_libro'><b>".$row['titolo']."</b></p>
        Libro di <b>".$row['username']."</b><br>
        prestato a <b>".$uname."</b>
        </div></div>";
      }
    }
    ?>
  </div>
</div>

</div></div>

<div id="menu_aggiungi" style="left: 100%">
  <form action="/prestiti/php/nuovoprestito.php" method="post">
    <h1 class="title" style="margin-bottom:15px;">Nuovo prestito</h1>

    <div class="scatola_aggiungi"><!--
    --><input type="text" placeholder="Qual è il libro in prestito?" name="titolo" required><!--
     --><div id="title_menu_options"></div></div>

    <div class="scatola_aggiungi"><!--
    --><input type="text" placeholder="A chi l'hai prestato?" name="debitore" required><!--
     --><div id="author_menu_options"></div></div>
     <h4>Data d'inizio prestito:</h4>
     <div class="scatola_aggiungi"><!--
     --><input type="date" name="data_inizio" required>
     </div>
     <h4>Data promemoria di fine prestito:</h4>
     <div class="scatola_aggiungi"><!--
     --><input type="date" name="data_promemoria" required>
     </div>

    <input type="submit" value="aggiungi" style="margin-top:20px;">
    <input type="reset" value="annulla" onclick="chiama_menu_aggiungi()">
  </form>
</div>

<script src="/libri/comune.js"></script>
<script src="/libri/libri.js"></script>
<script src="/prestiti/prestiti.js"></script>
</body>
</html>
