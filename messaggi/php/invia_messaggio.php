<?php

error_reporting(-1);
ini_set('display_errors', 'On');

session_start();
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';
$id_utente = $_SESSION['id_utente'];
$id_amico = mysqli_real_escape_string($conn,$_GET['id_amico']);
date_default_timezone_set('Europe/Rome');
$data=time();
$data=date('Y-m-d H:i:s', $data);
$testo = mysqli_real_escape_string($conn,$_GET['testo']);

$sql = "INSERT INTO messaggi (id_mittente,id_destinatario,data_ora,testo)
VALUES ('$id_utente','$id_amico','$data','$testo')";
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

echo "
<div>
  <p style='//margin-right:40px;'>$testo</p>
  <!--<i>$data</i>-->
</div>
";

mysqli_close($conn);

?>
