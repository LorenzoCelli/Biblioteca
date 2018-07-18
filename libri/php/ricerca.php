<link rel="stylesheet" type="text/css" href="main.css">
<?php session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

$uname = $_SESSION['uname'];
$id_utente = $_SESSION['id_utente'];
//$ricerca = $_POST['search_bar'];
$ricerca = 'pennacchio';

$sql = "SELECT * FROM libri WHERE MATCH(titolo, autore, descr) AGAINST ('978' IN NATURAL LANGUAGE MODE) OR isbn LIKE '%978%';";

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
