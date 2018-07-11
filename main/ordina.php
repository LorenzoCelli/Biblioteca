<link rel="stylesheet" type="text/css" href="main.css">
<?php session_start();

include '../connection.php';

$uname = $_SESSION['uname'];
$id_utente = $_SESSION['id_utente'];
$ordina = 'autoreza';//$_POST['ordina'];

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
  INNER JOIN posizione ON libri.id = posizione.id_libro
  INNER JOIN libreria ON libreria.id = posizione.id_libreria
  WHERE id_utente = '$id_utente'";

}

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)){
  echo "
  <div class='book_container' onclick='fill_info_book(".$row['id'].")'>
  <div class='book_image' style='background-image: url(".$row['img_url'].")'></div><!--
  --><div class='book_text'>
  <p class='book_title'>".$row['titolo']."</p>
  ".$row['autore']."
  </div>
  </div>
  ";
}
?>
