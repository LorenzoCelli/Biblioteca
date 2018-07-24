<?php

error_reporting(-1);
ini_set('display_errors', 'On');

session_start();
include $_SERVER['DOCUMENT_ROOT'].'/connection.php';
$id_utente = $_SESSION['id_utente'];
$id_amico = mysqli_real_escape_string($conn,$_GET['id_amico']);

$sql = "SELECT * FROM messaggi
WHERE id_mittente='$id_utente' OR id_destinatario='$id_utente'
OR id_mittente='$id_amico' OR id_destinatario='$id_amico'
ORDER BY data_ora ASC";
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

if ($result->num_rows == 0) {
  echo "";
}else {
  while ($row = mysqli_fetch_assoc($result)) {
    if ($row['id_mittente'] == $id_utente) {
      echo "
      <div class='messaggio' style='text-align:right'>
        <div>
          <p style='//margin-right:40px;'>".$row['testo']."</p>
          <!--<i>".$row['data_ora']."</i>-->
        </div>
      </div>";
    }else{
      echo "
      <div class='messaggio' style='text-align:left'>
        <div>
          <p style='//margin-left:40px;'>".$row['testo']."</p>
          <!--<i>".$row['data_ora']."</i>-->
        </div>
      </div>";
    }
  }
}

mysqli_close($conn);

?>
