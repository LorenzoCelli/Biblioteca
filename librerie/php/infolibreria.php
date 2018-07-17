<?php session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

$uname = $_SESSION['uname'];
$id_utente = $_SESSION['id_utente'];
$id_libreria = $_GET['id'];

$sql = "SELECT * FROM libreria WHERE id_utente = ".$id_utente." AND id = ".$id_libreria;
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

if($result->num_rows == 0){
    echo "<l_img src='http://pa1.narvii.com/6776/24a0a36313ea44f1abac45bcc3c70465fd27f0a2_00.gif' height='200px'>";
    return;
}

$row = mysqli_fetch_assoc($result);
$nome = $row["nome"];
$descr = $row["descr"];
$n_scaffali = $row["n_scaffali"];
$colore = $row["colore"];
?>

<div class="info_button_bar">
   <div onclick="modifica_libreria(<?php echo $id_libreria;?>)" class="info_hover_div"><img src="../imgs/matita.svg" style="height: 50px"></div><!--
--><div onclick="elimina_libreria(this, <?php echo $id_libreria;?>)" class="info_hover_div"><img src="../imgs/cestino.svg" style="height: 50px"></div><!--
--><div onclick="close_info_menu()" class="info_hover_div"><img src="../imgs/croce.svg" style="height: 50px"></div>
</div>

<div class="info_box">
    <div style="display: none" class="info_tooltip">titolo</div>
    <h1 class="info_p"><?php echo $nome;?></h1>
</div>
<div class="info_box">
    <div style="display: none" class="info_tooltip">descrizione</div>
    <p class="info_p"><?php echo $descr;?></p>
</div>
<div class="info_box" style="display: none">
    <div style="display: none" class="info_tooltip">colore etichetta</div>
    <p class="info_p"><?php echo $colore;?></p>
</div>
<div class="info_box" style="display: none">
    <div class="info_tooltip">numero scaffali</div>
    <p class="info_p"><?php echo $n_scaffali;?></p>
</div>

<div class="to_hide">

<?php
for ($i=1; $i <= $n_scaffali; $i++) {
  echo "
  <div class='scaffale_titolo'>Scaffale $i</div>
  <div class='scaffale_info_menu'>
  ";

  $sql_libri = "SELECT * FROM libri
  INNER JOIN posizione ON libri.id = posizione.id_libro
  WHERE libri.id_utente = ".$id_utente." AND posizione.id_libreria = ".$id_libreria." AND posizione.n_scaffale = ".$i;
  $result_libri = mysqli_query($conn, $sql_libri) or trigger_error(mysqli_error($conn));

  while ($riga = mysqli_fetch_assoc($result_libri)) {
    echo "
      <div style=\"background-image: url('".$riga['img_url']."')\" onclick='fill_info_book2(".$riga['id'].")'>
      </div>
    ";
  }

  echo "
  </div>
  ";
}
?>
</div>
<div class="to_show">
    <button onclick="aggiorna_libreria(this, <?echo $id_libreria?>)">Salva</button>
    <button>Annulla</button>
</div>
