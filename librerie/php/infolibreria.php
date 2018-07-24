<?php session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

$uname = $_SESSION['uname'];
$id_utente = $_SESSION['id_utente'];
$id_libreria = mysqli_real_escape_string($conn,$_GET['id']);

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
$scaffali = "";
$c = 0;

$sql_libri = "SELECT * FROM libri
INNER JOIN posizione ON libri.id = posizione.id_libro
WHERE libri.id_utente = '$id_utente' AND posizione.id_libreria = '$id_libreria'
ORDER BY posizione.n_scaffale ASC";
$result_libri = mysqli_query($conn, $sql_libri) or trigger_error(mysqli_error($conn));
$cont_libri = [];
while ($riga = mysqli_fetch_assoc($result_libri)) {
  $cont_libri[$c][0] = $riga['n_scaffale'];
  $cont_libri[$c][1] = $riga['img_url'];
  $cont_libri[$c][2] = $riga['id'];
  $c++;
}
for ($i=1; $i <= $n_scaffali; $i++) {
  $scaffali .= "<div class='scaffale_titolo'>Scaffale $i</div><div class='scaffale_info_menu'>";
  for ($j=0; $j < count($cont_libri); $j++) {
    if ($cont_libri[$j][0] == $i) {
      $scaffali.="
        <div style=\"background-image: url('".$cont_libri[$j][1]."')\" onclick='info_libro(".$cont_libri[$j][2].")'>
        </div>
      ";
    }
  }
  $scaffali.="
  </div>";
}

?>

<div class="info_barrabottoni">
   <div onclick="modifica_libreria(<?php echo $id_libreria;?>)" class="info_hover_div"><img src="../imgs/matita.svg" style="height: 50px"></div><!--
--><div onclick="elimina_libreria(this, <?php echo $id_libreria;?>)" class="info_hover_div"><img src="../imgs/cestino.svg" style="height: 50px"></div><!--
--><div onclick="close_info_menu()" class="info_hover_div"><img src="../imgs/croce.svg" style="height: 50px"></div>
</div>

<div class="scatola_info">
    <div style="display: none" class="nome_scatola_info">titolo</div>
    <h1 class="testo_scatola_info"><?php echo $nome;?></h1>
</div>
<div class="scatola_info">
    <div style="display: none" class="nome_scatola_info">descrizione</div>
    <p class="testo_scatola_info"><?php echo $descr;?></p>
</div>
<div class="scatola_info" style="display: none">
    <div style="display: none" class="nome_scatola_info">colore etichetta</div>
    <p class="testo_scatola_info"><?php echo $colore;?></p>
</div>
<div class="scatola_info" style="display: none">
    <div class="nome_scatola_info">numero scaffali</div>
    <p class="testo_scatola_info"><?php echo $n_scaffali;?></p>
</div>

<div class="to_hide">

<?php
echo $scaffali;
?>
</div>
<div class="to_show">
    <button onclick="aggiorna_libreria(this, <?echo $id_libreria?>)">Salva</button>
    <button>Annulla</button>
</div>
