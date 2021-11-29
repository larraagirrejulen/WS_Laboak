<?php include "../php/DbConfig.php" ?>
<?php
    session_start();
    $logeatuta = 0;
    if(isset($_SESSION["posta"]) && isset($_SESSION["mota"]) && isset($_SESSION['img'])){
      $logeatuta = 1;
      $session_posta = $_SESSION["posta"];
      $session_mota = $_SESSION["mota"];
      $session_irudia = $_SESSION['img'];

      $dbc = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);

      $sql = "SELECT egoera FROM users WHERE posta='$session_posta';";

      if($ema = $dbc->query($sql)){
        if(mysqli_num_rows($ema) != 1 ||  array_values($ema->fetch_assoc())[0] != 1){
          include_once "../php/LogOut.php";
        }
      }else{
        include_once "../php/LogOut.php";
      }
    }
  ?>
