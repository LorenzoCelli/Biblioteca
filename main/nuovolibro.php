<?php

error_reporting(-1);
ini_set('display_errors', 'On');

session_start();
$id_utente = $_SESSION['id_utente'];
include '../connection.php';

$isbn = $_POST["isbn"];
$titolo = mysqli_real_escape_string($conn, $_POST["titolo"]);
$autore = mysqli_real_escape_string($conn,$_POST["autore"]);
$generi = explode(",",mysqli_real_escape_string($conn, $_POST["generi"]));
$descr = mysqli_real_escape_string($conn,$_POST["descr"]);
$img_url = mysqli_real_escape_string($conn,$_POST["img_url"]);
$nome_libreria = mysqli_real_escape_string($conn,$_POST["nome_libreria"]);
$scaffale = mysqli_real_escape_string($conn,$_POST["scaffale"]);


$sql = "INSERT INTO libri (isbn,id_utente,titolo,autore,descr,img_url)
VALUES ('$isbn','$id_utente','$titolo','$autore','$descr','$img_url')";
$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

if($result){
    $last_id = $conn->insert_id;
    $sql = "SELECT * FROM libreria WHERE id_utente = '$id_utente' AND nome = '$nome_libreria'";
    $result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

    if($result && $result->num_rows == 1) {
        $libr = mysqli_fetch_assoc($result);
        $id_libreria = $libr['id'];
        $sql = "INSERT INTO posizione (id_libro,n_scaffale,id_libreria)
                VALUES ($last_id,'$scaffale','$id_libreria')";
        $results = mysqli_query($conn, $sql);
    }

    for ($i = 0; $i < count($generi); $i++) {
        $sql = "INSERT INTO generi (id_libro,genere)
        VALUES ($last_id,'$generi[$i]')";
        mysqli_query($conn, $sql);
    }

    echo   "<div class='book_image' style='background-image: url(" . $img_url . ")'></div><!--
         --><div class='book_text'>
            <p class='book_title'>" . $titolo . "</p>
            " . $autore . "
            </div>";
}

mysqli_close($conn);

?>
