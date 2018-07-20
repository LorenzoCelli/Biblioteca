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

$sql = "SELECT id FROM libreria WHERE id_utente = '$id_utente' AND nome = '$libreria'";
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

$err = 0;

if($result && $result->num_rows == 1){
    $row = mysqli_fetch_assoc($result);
    $id_libreria = $row["id"];

    $sql = "UPDATE libri SET isbn= '".$isbn."', titolo= '".$titolo."', autore= '".$autore."', descr= '".$descr."', img_url= '".$img_url."' WHERE id = ".$id_libro;
    $result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

    if($result){
        $sql = "SELECT id_libro FROM posizione WHERE id_libro = ".$id_libro;
        $result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

        if($result && $result->num_rows == 1){
            $sql = "UPDATE posizione SET n_scaffale= ".$scaffale.", id_libreria= ".$id_libreria." WHERE id_libro = ".$id_libro;
            $result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

            if(!$result){
                $err+=1;
            }
        }else{
            $sql = "INSERT INTO posizione (id_libro, n_scaffale, id_libreria) VALUES ($id_libro, $scaffale, $id_libreria)";
            $result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

            if(!$result){
                $err+=1;
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


        if($err == 0){
            echo "
                <div class='immagine_pillola_libro' style='background-image: url(" . $img_url . ")'></div><!--
             --><div class='testo_pillola_libro'>
                <p class='titolo_pillola_libro'>" . $titolo . "</p>
                " . $autore . "
                </div>
            ";
        }

    }
}
mysqli_close($conn);
