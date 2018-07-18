<link rel="stylesheet" type="text/css" href="main.css">
<?php session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

$uname = $_SESSION['uname'];
$id_utente = $_SESSION['id_utente'];
$ordina = 'libreria';//$_POST['ordina'];

if ($ordina == 'titoloaz') {
  $sql = "SELECT * FROM libri
  WHERE id_utente = '$id_utente'
  ORDER BY titolo ASC";

}elseif ($ordina == 'titoloza') {
  $sql = "SELECT * FROM libri
  WHERE id_utente = '$id_utente'
  ORDER BY titolo DESC";

}elseif ($ordina == 'autoreaz') {
  $sql = "SELECT * FROM libri
  WHERE id_utente = '$id_utente'
  ORDER BY autore ASC";

}elseif ($ordina == 'autoreza') {
  $sql = "SELECT * FROM libri
  WHERE id_utente = '$id_utente'
  ORDER BY autore DESC";

}elseif ($ordina == 'libreria') {
  $sql = "SELECT * FROM libri
  INNER JOIN posizione
  ON libri.id = posizione.id_libro
  INNER JOIN libreria
  ON libreria.id = posizione.id_libreria
  WHERE libri.id_utente = '$id_utente'";

}

$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

while($row = mysqli_fetch_assoc($result)){
  echo "
  <div class='pillola_libro' onclick='info_libro(".$row['id'].")'>
  <div class='immagine_pillola_libro' style='background-image: url(".$row['img_url'].")'></div><!--
  --><div class='testo_pillola_libro'>
  <p class='titolo_pillola_libro'>".$row['titolo']."</p>
  ".$row['autore']."
  </div>
  </div>
  ";
}
?>
