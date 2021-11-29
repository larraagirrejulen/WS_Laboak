<?php 
    require_once "../php/CaptureLoginInfo.php";
    require_once "../php/DbConfig.php";
    $status = 0;
    $errorea = "Ezin duzu zerbitzu hau atzitu";
    echo "<?xml version='1.0'>";
    echo "<erantzuna>";
    if($logeatuta && $session_mota == "admin"){
        if(isset($_POST["posta"])){
            $posta = $_POST["posta"];

            $status = 1;
            $dbq = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);
            
            $sql = "SELECT mota FROM users WHERE posta='$posta';";

            if(!$ema=$dbq->query($sql)){
                $status = 0;
                $errorea = "Errorea borratzerako unean";
            }else{
                $mota = ($ema -> fetch_assoc());
                $mota = array_values($mota)[0];
                if($mota == 'admin'){
                    $status = 0;
                    $errorea = "Errorea borratzerako unean, ezinezkoa da erabiltzaile hau borratzea";
                }
            }
            
            if($status){
                $sql = "DELETE FROM users WHERE posta='$posta';";
                
    
                if(!$ema=$dbq->query($sql)){
                    $status = 0;
                    $errorea = "Ez dago erabiltzailea datu basean";
                }
            }

        }
    }
    
    if($status){
        echo "<egoera>success</egoera>";
        echo "<erantzunEgokia> $posta erabiltzailea era egokian borratu egin da</erantzunEgokia>";
    }else{
        echo "<egoera>errorea</egoera>";
        echo "<errorea>$errorea</erroera>";
    }
    echo "</erantzuna>";
?>