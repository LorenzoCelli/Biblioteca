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
    $str = str_replace(";"," ",$str);
    $str = str_replace(","," ",$str);
    $str = str_replace(":"," ",$str);
    $str = str_replace("-"," ",$str);
    $str = str_replace("_"," ",$str);
    $str = str_replace("'"," ",$str);
    $str = str_replace('"'," ",$str);
    $str = str_replace("."," ",$str);
    return $str;
}

$sql = "SELECT * FROM libreria WHERE id_utente = '$id_utente'";

$result = mysqli_query($conn, $sql) or trigger_error(mysqli_error($conn));

if(!$result){
    return;
}

$titoli = array();

while($row = mysqli_fetch_assoc($result)){
    $lev = allineamento($chiave, $row["nome"]);
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
    if($titoli[$i][1] < 1) continue;
    echo "
    <div class='pillola_libro' onclick='info_libreria(".$row["id"].")'>
        <div class='immagine_pillola_libro' style='background-color: ".$row["colore"]."'></div><!--
     --><div class='testo_pillola_libro'>
            <p class='titolo_pillola_libro'>".$row["nome"]."</p>".$row["descr"]."
        </div>
    </div>
    ";
}