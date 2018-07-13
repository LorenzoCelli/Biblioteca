<?php session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

include '../connection.php';

$uname = $_SESSION['uname'];
$id_utente = $_SESSION['id_utente'];
$id_libreria = $_GET['id'];

$sql = "SELECT * FROM libreria WHERE id_utente = ".$id_utente." AND id = ".$id_libreria;
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

if($result->num_rows == 0){
    echo "<l_img src='http://pa1.narvii.com/6776/24a0a36313ea44f1abac45bcc3c70465fd27f0a2_00.gif' height='200px'>";
    return;
}

$row = mysqli_fetch_assoc($result);
$nome = $row["nome"];
$descr = $row["descr"];
$n_scaffali = $row["n_scaffali"];
?>

<div class="info_button_bar">
   <div onclick="edit_book(<?php echo $id_libreria;?>)" class="info_hover_div"><img src="../imgs/matita.svg" style="height: 50px"></div><!--
--><div onclick="delete_book(<?php echo $id_libreria;?>,this)" class="info_hover_div"><img src="../imgs/cestino.svg" style="height: 50px"></div><!--
--><div onclick="closeLibrary()" class="info_hover_div"><img src="../imgs/croce.svg" style="height: 50px"></div>
</div>
<h1 style="margin-top: 20px;"><?php echo $nome;?></h1>
<h4 style="margin-top: 0px; margin-bottom: 5px;"><?php echo $descr;?></h4>

<div class="cercaInput"><input class="cercaLib"><img src="../imgs/lente.png" width="32px" class="cercaImg"></div>

<?php
for ($i=1; $i <= $n_scaffali; $i++) {
  echo "
  <div class='scaffaleTitolo'>
    <h5>Scaffale $i</h5>
  </div>
  <div class='libscaffale_menu'>
  ";

  $sql_libri = "SELECT * FROM libri
  INNER JOIN posizione ON libri.id = posizione.id_libro
  WHERE libri.id_utente = ".$id_utente." AND posizione.id_libreria = ".$id_libreria." AND posizione.n_scaffale = ".$i;
  $result_libri = mysqli_query($conn, $sql_libri) or trigger_error(mysqli_error($conn));

  while ($riga = mysqli_fetch_assoc($result_libri)) {
    echo "
      <div class='boxlibro_menu'>
        <img src='".$riga['img_url']."' class='libriscaffali' onclick='fill_info_book2(".$riga['id'].")'>
      </div>
    ";
  }

  echo "
  </div>
  ";
}
?>
