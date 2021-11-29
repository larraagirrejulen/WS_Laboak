<?php 
    require_once "../php/CaptureLoginInfo.php";
    require_once "../php/DbConfig.php";
    $status = 0;
    $errorea = "Ezin duzu zerbitzu hau atzitu";
    echo "<?xml version='1.0'>";
    echo "<erantzuna>";
    if($logeatuta && $session_mota == "admin"){
        if(isset($_POST["posta"])){
            $status = 1;
            $posta = $_POST["posta"];
            $sql = "SELECT egoera FROM users WHERE posta='$posta';";
            $dbq = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);

            if(!$ema=$dbq->query($sql)){
                $status = 0;
                $errorea = "Ez dago erabiltzailea datu basean";
            }

            if($status && $egoera = $ema -> fetch_assoc()){
                $egoera = array_values($egoera)[0];
                if($egoera == 1){
                    $egoera = 2;
                }else{
                    $egoera = 1;
                }
                $sql = "UPDATE users SET egoera=$egoera WHERE posta='$posta';";
                $dbq = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);
                
                if(!$ema=$dbq->query($sql)){
                    $status = 0;
                    $errorea = "Errorea datuak aldatzerakoan";
                }
            }
        }
    }
    
    if($status){
        echo "<egoera>success</egoera>";
        echo "<erantzunEgokia>$egoera</erantzunEgokia>";
    }else{
        echo "<egoera>errorea</egoera>";
        echo "<errorea>$errorea</erroera>";
    }
    echo "</erantzuna>";
?>