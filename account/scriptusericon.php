<?php

$sql = "SELECT * FROM utenti WHERE id = '$id_utente'";
$results = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($results);
$id_avatar = $row['id_avatar'];

switch ($id_avatar) {
  case 0:
    $img = "../imgs/usericon.svg";
    break;
  case 1:
    $img = "../imgs/avatars/1.png";
    break;
  case 2:
    $img = "../imgs/avatars/2.png";
    break;
  case 3:
    $img = "../imgs/avatars/3.png";
    break;
  case 4:
    $img = "../imgs/avatars/4.png";
    break;
  case 5:
    $img = "../imgs/avatars/5.png";
    break;
  case 6:
    $img = "../imgs/avatars/6.png";
    break;
}

?>
