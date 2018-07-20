<?php
session_start();

error_reporting(-1);
ini_set('display_errors', 'On');

include $_SERVER['DOCUMENT_ROOT'].'/connection.php';
$id_utente = $_SESSION['id_utente'];
$chiave = $_GET["ordina"];

function insertAt($arr, $value, $index) {
    if(array_key_exists($index , $arr)){
        $arr = insertAt($arr, $arr[$index], $index+1);
    }
    $arr[$index] = $value;
    return $arr;
}

function allineamento($str1, $str2){
    $str1 = pulisci(strtolower($str1));
    $str2 = pulisci(strtolower($str2));
    $segmenti = array("");

    $i_s = 0;   // indice segmenti
    $i = 0;     // indice chiave
    while($i<strlen($str1)){
        $n_s = $segmenti[$i_s].$str1[$i];
        if(contains($str2, $n_s)){
            $segmenti[$i_s] = $n_s;
            $i++;
        }else{
            if(strlen($segmenti[$i_s])===0){
                $i++;
            }else{
                $i_s++;
                $segmenti[$i_s] = "";
            }
        }
    }
    $punteggio = 0;
    for($j=0; $j<count($segmenti); $j++){
        if(strlen($segmenti[$j]) > 1){
            $punteggio += strlen($segmenti[$j]);
        }
    }
    return $punteggio;
}
/*

function differenze($str1, $str2) {
    $str1 = strtolower($str1);
    $str2 = strtolower($str2);
    $comuni = parole_comuni($str1, $str2);
    $mancanti = 0;
    $ultimo = 0;
    while (strlen($str1)) {
        $futuro_ultimo = ! strpos($str2, $str1[0]) === false;
        if ($futuro_ultimo) {
            $str2 = preg_replace("/".$str1[0]."/","",$str2,1);
            $ultimo*=2;
        } else {
            $mancanti++;
        }
        $str1 = preg_replace("/" . $str1[0] . "/", "", $str1, 1);
    }
    return ($mancanti + strlen($str2))/$comuni;
}

function parole_comuni($str1, $str2){
    $str1 = trim(pulisci($str1));
    $str2 = trim(pulisci($str2));
    $arr = explode(" ", $str1);
    $non_trovate = 0;
    $trovate = 0;
    for($i=0; $i<count($arr); $i++){
        if(strpos($str2, $arr[$i]) === false){
            $non_trovate += 1;
        }else{
            $trovate +=1;
        }
    }
    $non_trovate += count(explode(" ",$str2))-$trovate;
    return $trovate/($non_trovate+$trovate)+0.05;
}
*/

function contains($cercaqui, $trovami){
    return strpos($cercaqui, $trovami) !== false;
}

function pulisci($str){
    $str = elimina_punteggiatura($str);
    while(strpos($str, "  ") !== false){
        $str = str_replace("  "," ",$str);
    }
    return $str;
}
function elimina_punteggiatura($str){
    $str = str_replace(";","",$str);
    $str = str_replace(",","",$str);
    $str = str_replace(":","",$str);
    $str = str_replace("-","",$str);
    $str = str_replace("_","",$str);
    $str = str_replace("'","",$str);
    $str = str_replace('"',"",$str);
    $str = str_replace(".","",$str);
    return $str;
}

$sql = "SELECT * FROM libri WHERE id_utente = '$id_utente'";

$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

if(!$result){
    return;
}

$titoli = array();

while($row = mysqli_fetch_assoc($result)){
    $lev = allineamento($chiave, $row["titolo"]);
    $a = true;
    for($i=0; $i<count($titoli); $i++){
        if($lev>$titoli[$i][1]){
            $titoli = insertAt($titoli, array($row, $lev), $i);
            $a = false;
            break;
        }
    }
    if($a){
        $titoli[count($titoli)] = array($row, $lev);
    }
}

for($i=0; $i<count($titoli); $i++){
    $row = $titoli[$i][0];
    if($titoli[$i][0] < 1) continue;
    echo "
        <div class='pillola_libro' onclick='info_libro(".$row['id'].")'>
        <div class='immagine_pillola_libro' style='background-image: url(".$row['img_url'].")'></div><!--
        --><div class='testo_pillola_libro'>
        <p class='titolo_pillola_libro'>".$row['titolo']."</p>
        ".$row['autore']."
        </div>
        </div>
     ";
}





/*
echo "
<div class='pillola_libro' onclick='info_libro(".$row['id'].")'>
<div class='immagine_pillola_libro' style='background-image: url(".$row['img_url'].")'></div><!--
--><div class='testo_pillola_libro'>
<p class='titolo_pillola_libro'>".$row['titolo']."</p>
".$row['autore']."
</div>
</div>
 ";
*/