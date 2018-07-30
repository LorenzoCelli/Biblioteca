<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

$id_utente = $_SESSION['id_utente'];
$ordina = mysqli_real_escape_string($conn,$_POST['ordina']);

if ($ordina == 'titoloaz') {
  $sql = "SELECT * FROM libri
  LEFT JOIN prestiti ON libri.id = prestiti.id_libro
  WHERE libri.id_utente = '$id_utente'
  ORDER BY libri.titolo ASC";

}elseif ($ordina == 'titoloza') {
  $sql = "SELECT * FROM libri
  LEFT JOIN prestiti ON libri.id = prestiti.id_libro
  WHERE libri.id_utente = '$id_utente'
  ORDER BY libri.titolo DESC";

}elseif ($ordina == 'autoreaz') {
  $sql = "SELECT * FROM libri
  LEFT JOIN prestiti ON libri.id = prestiti.id_libro
  WHERE libri.id_utente = '$id_utente'
  ORDER BY libri.autore ASC";

}elseif ($ordina == 'autoreza') {
  $sql = "SELECT * FROM libri
  LEFT JOIN prestiti ON libri.id = prestiti.id_libro
  WHERE libri.id_utente = '$id_utente'
  ORDER BY libri.autore DESC";

}elseif ($ordina == 'generi'){
  $sql ="SELECT * FROM libri
  LEFT JOIN prestiti ON libri.id = prestiti.id_libro
  INNER JOIN generi ON libri.id = generi.id_libro
  WHERE libri.id_utente = '$id_utente'
  ORDER BY generi.genere ASC";

}elseif ($ordina == 'libreria') {
  $sql = "SELECT * FROM libri
  LEFT JOIN prestiti ON libri.id = prestiti.id_libro
  INNER JOIN posizione
  ON libri.id = posizione.id_libro
  INNER JOIN libreria
  ON libreria.id = posizione.id_libreria
  WHERE libri.id_utente = '$id_utente'";

}

$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

if(!$result){
    return;
}
if ($ordina == 'generi') {
  $temp = "";
  while($row = mysqli_fetch_assoc($result)){
    if ($row['genere'] != "") {
      if ($row['genere'] != $temp) {
        echo "<h3 style='color:white'>".$row['genere']."</h3>";
      }
      if (is_null($row['data_promemoria'])) $p = "";
      elseif(is_null($row['data_fine'])) $p = "<div>In prestito</div>";
      if ($row['letto'] == 0) $l = "";
      elseif ($row['letto'] == 1) $l = "<div>Già letto</div>";
      echo "
      <div class='pillola_libro' onclick='info_libro(".$row['id'].")'>
      <div class='immagine_pillola_libro' style='background-image: url(".$row['img_url'].")'></div><!--
      --><div class='testo_pillola_libro'>
      <p class='titolo_pillola_libro'>".$row['titolo']."</p>
      ".$row['autore']."
      <div class='info_tag'>$p$l</div>
      </div>
      </div>
      ";
      $temp = $row['genere'];
    }
  }
  return;
}
if ($ordina == 'libreria') {
  $temp = "";
  while($row = mysqli_fetch_assoc($result)){
    if ($row['nome'] != $temp) {
      echo "<h3 style='color:white'>".$row['nome']."</h3>";
    }
    if (is_null($row['data_promemoria'])) $p = "";
    elseif(is_null($row['data_fine'])) $p = "<div>In prestito</div>";
    if ($row['letto'] == 0) $l = "";
    elseif ($row['letto'] == 1) $l = "<div>Già letto</div>";
    echo "
    <div class='pillola_libro' onclick='info_libro(".$row['id'].")'>
      <div class='immagine_pillola_libro' style='background-image: url(".$row['img_url'].")'></div><!--
      --><div class='testo_pillola_libro'>
        <p class='titolo_pillola_libro'>".$row['titolo']."</p>
        ".$row['autore']."
        <div class='info_tag'>$p$l</div>
      </div>
    </div>
    ";
    $temp = $row['nome'];
  }
  return;
}
while($row = mysqli_fetch_assoc($result)){
  if (is_null($row['data_promemoria'])) $p = "";
  elseif(is_null($row['data_fine'])) $p = "<div> style='background-color:#dc4242;'>In prestito</div>";
  if ($row['letto'] == 0) $l = "";
  elseif ($row['letto'] == 1) $l = "<div style='background-color:	#dc8f42;'>Già letto</div>";
  echo "
  <div class='pillola_libro' onclick='info_libro(".$row['id'].")'>
    <div class='immagine_pillola_libro' style='background-image: url(".$row['img_url'].")'></div><!--
    --><div class='testo_pillola_libro'>
      <p class='titolo_pillola_libro'>".$row['titolo']."</p>
      ".$row['autore']."
      <div class='info_tag'>$p$l</div>
    </div>
  </div>
  ";
}
?>
