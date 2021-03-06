<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

include $_SERVER['DOCUMENT_ROOT'].'/connection.php';

$id_utente = mysqli_real_escape_string($conn,$_SESSION['id_utente']);
$id_libro = mysqli_real_escape_string($conn,$_POST["id"]);
$isbn = mysqli_real_escape_string($conn,$_POST["isbn"]);
$generi = explode(",",mysqli_real_escape_string($conn, $_POST["generi"]));
$titolo = mysqli_real_escape_string($conn,$_POST["titolo"]);
$autore = mysqli_real_escape_string($conn,$_POST["autore"]);
$libreria = mysqli_real_escape_string($conn,$_POST["libreria"]);
$scaffale = mysqli_real_escape_string($conn,$_POST["scaffale"]);
$img_url = mysqli_real_escape_string($conn,$_POST["img_url"]);
$descr = mysqli_real_escape_string($conn,$_POST["descr"]);
$letto = mysqli_real_escape_string($conn,$_POST["letto"]);
echo $letto;
$sql = "SELECT * FROM
libri LEFT JOIN posizione ON libri.id = posizione.id_libro
WHERE libri.id_utente = $id_utente AND libri.id = $id_libro";

$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

if($result && $result->num_rows === 1){
    $row = mysqli_fetch_assoc($result);
    $posizione = $row["id_libreria"];

    $sql = "UPDATE libri SET isbn= '".$isbn."', titolo= '".$titolo."', autore= '".$autore."', descr= '".$descr."', img_url= '".$img_url."', letto=$letto WHERE id = ".$id_libro;
    $result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

    if($result){

        $sql = "SELECT id FROM libreria WHERE libreria.nome = '$libreria' AND libreria.id_utente = $id_utente";
        $result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

        if($result && $result->num_rows === 1){
            $id_libreria = mysqli_fetch_assoc($result)["id"];

            if(is_null($posizione)){
                $sql = "INSERT INTO posizione (id_libro, n_scaffale, id_libreria) VALUES ($id_libro, $scaffale, $id_libreria)";
                $result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));
            }else{
                $sql = "UPDATE posizione SET n_scaffale= ".$scaffale.", id_libreria= ".$id_libreria." WHERE id_libro = ".$id_libro;
                $result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));
            }
        }

        $sql = "DELETE FROM generi WHERE id_libro = ".$id_libro;
        $result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

        if($result){
            for ($i = 0; $i < count($generi); $i++) {
                if($generi[$i] == "") break;
                $sql = "INSERT INTO generi (id_libro,genere) VALUES ($id_libro,'$generi[$i]')";
                mysqli_query($conn, $sql);
            }
        }


        echo "<div class='immagine_pillola_libro' style='background-image: url(".$img_url.")'></div><!--
           --><div class='testo_pillola_libro'>
                <div>".$autore."</div>
                <div class='titolo_pillola_libro'>".$titolo."</div>
              </div>
              <div class='info_tag'></div>
            </div>";
    }
}
mysqli_close($conn);
