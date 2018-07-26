<?php

error_reporting(-1);
ini_set('display_errors', 'On');

session_start();
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';
$id_utente = $_SESSION['id_utente'];
$id_amico = mysqli_real_escape_string($conn,$_GET['id_amico']);
$num_msg = (int) mysqli_real_escape_string($conn,$_GET['num_msg']);

$sql = "SELECT * FROM messaggi
WHERE id_mittente='$id_amico' AND id_destinatario='$id_utente'
ORDER BY data_ora DESC";
$result = mysqli_query($conn, $sql);

if ($result->num_rows == $num_msg) {
  return;
}elseif ($result->num_rows > $num_msg) {
  $diff = $result->num_rows - $num_msg;
  $num_msg = 0;
  while ($row = mysqli_fetch_assoc($result)) {
    if ($num_msg < $diff) {
      echo "
      <div class='messaggio' style='text-align:left'>
        <div>
          <p>".$row['testo']."</p>
          <!--<i>".$row['data_ora']."</i>-->
        </div>
      </div>
      ";
    }
    $num_msg++;
  }
}

mysqli_close($conn);

?>
