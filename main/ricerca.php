<link rel="stylesheet" type="text/css" href="main.css">
<?php session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

include '../connection.php';

$uname = $_SESSION['uname'];
$id_utente = $_SESSION['id_utente'];
//$ricerca = $_POST['search_bar'];
$ricerca = 'pennacchio';

$sql = "SELECT * FROM libri WHERE MATCH(titolo,autore,descr) AGAINST ('$ricerca');";

$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

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
