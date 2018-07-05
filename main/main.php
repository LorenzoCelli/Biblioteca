<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>La tua biblioteca</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="main.css">
    <link href="https://fonts.googleapis.com/css?family=Vollkorn:400,900" rel="stylesheet">
</head>
<body>

<h1>La tua biblioteca.</h1>
<a href="../nuovolibro.html"><img class="menu_button" src="../imgs/piu.png" style="border-right: 2px solid #ececec"></a><!--
--><a href="../cerca.html"><img class="menu_button" src="../imgs/lente.png"></a><br><br>


<script>
  function ingrandisci(container) {
    container.style.width = "1000px";
    container.style.height = "200px";
    container.getElementsByClassName("book_info")[0].style.display = "inline-block";
  }
</script>

<?php

$id_utente = $_SESSION['id_utente'];

include '../connection.php';

$sql = "SELECT * FROM libri WHERE id_utente = '$id_utente'";
$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)){
  echo "
  <div class='book_container' onclick='ingrandisci(this);'>
      <div class='book_image' style='background-image: url()'></div><!--
   --><div class='book_text'>
        ".$row['titolo']."
      </div>
      <div class='book_info'>
        Autore: ".$row['autore']."<br>
        Descrizione: ".$row['desc']."<br>
        Generi:
  ";
  $id_libro = $row['id'];
  $generi = mysqli_query($conn, "SELECT * FROM generi WHERE id_libro = '$id_libro'");
  if ($generi->num_rows == 0) echo "---";
  else{
    while ($gen = mysqli_fetch_assoc($generi)) echo $gen['genere']."<br>";
  }
  echo "

      </div>
  </div>
  ";
}

?>

<br><br>
<div class="book_container" onclick="ingrandisci(this)">
    <div class="book_image" style="background-image: url(https://images-na.ssl-images-amazon.com/images/I/51V%2Bb2rUV3L._SX356_BO1,204,203,200_.jpg)"></div><!--
 --><div class="book_text"> La mia casa è dove sono </div>
</div>
<div class="book_container" onclick="ingrandisci(this)">
    <div class="book_image" style="background-image: url(https://mr.comingsoon.it/imgdb/PrimoPiano/impaginate/AnimaliFantastici.jpg)"></div><!--
 --><div class="book_text"> Gino Bottiglieri </div>
</div>
<div class="book_container" onclick="ingrandisci(this)">
    <div class="book_image" style="background-image: url(http://pennablu.it/img/copertina.jpg)"></div><!--
 --><div class="book_text"> asdads </div>
</div>

</body>
</html>
