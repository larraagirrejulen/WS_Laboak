<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <link rel="stylesheet" type="text/css" href="../styles/BoxTypes.css">
  <style type="text/css">
    label, input{
      margin-bottom: 2px;
      margin-top: 2px;
      margin-right: 4px;
      vertical-align: middle;
    }
    form{
      margin-left: 50px;
      text-align: left;
    }
    h2{
      margin-bottom: 4px;
    }
  </style>
</head>

<body>
<?php include '../php/DbConfig.php' ?>
<?php include_once "../php/IncreaseGlobalCounter.php" ?>
  <?php include "../php/Menus.php" ?>

  <section class="main" id="s1">
    <?php
      $log_MSG = "";

      // Logeatuta badago.
      if($logeatuta){
        echo ("<h1>Jadanik logeatuta zaude</h1><br><br>");
        echo ("<a href='LogOut.php'> Saioa Itxi </a> <br>");
        echo ("<a href='Layout.php'> Hasierako Orrira joan </a> <br>");

      // Formularioa bete badu.
      }else if(isset($_POST['posta']) && array_key_exists("pasahitza", $_POST)){

        // DBtik erabiltzailearen deiturak lortu.
        $posta = $_POST['posta'];
        $pasahitza = $_POST['pasahitza'];
        $pasahitza = crypt($pasahitza, 'st');
        $dbq = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);
        $sql = "SELECT deiturak, mota, egoera, irudia, imgdata FROM users WHERE posta='$posta' AND pasahitza='$pasahitza';";
        if(!$ema=$dbq->query($sql)){
          die('Errorea frogaketan: '.$dbq->error."<br>");
        }

        // Erabiltzailea existitzen dela ziurtatu.
        if(mysqli_num_rows($ema) == 1){
          $erabInfo = mysqli_fetch_row($ema);

          if($erabInfo[2] == 1){
            $deiturak = $erabInfo[0];
            $mota = $erabInfo[1];
            $img = $emaitzak[2]; //Argazkia blob base 64
            $img_props = $emaitzak[3]; //Argazkiaren formatua

            $log_MSG = $log_MSG."Kredentzial egokiak <br> <br>"; //TODO Ez da beharrezkoa
            $log_MSG = $log_MSG."<h1> Ongi Etorri '$dseiturak' </h1>";


            $_SESSION['posta'] = $posta;
            $_SESSION['mota'] = $mota;
            erabUserCounterGehitu($posta);

            if($img != null && $img_props != null){
              $img_name = explode(-1, $img_props);
              $img_name = $img_name[count($img_name)-1];
              $_SESSION['img'] = "data:image/".$img_name.";base64,$img_props";
            }else{
              $_SESSION['img'] = "../images/question_mark.png"
            }

            if($mota == "ikasle"){
              header("location: ../php/HandlingQuizezAjax.php");
            }else if ($mota == "ikasle") {
              header("location: ../php/HandlingQuizezAjax.php"); //TODO
            }else if ($mota == "admin"){
              header("location: ../php/HandlingAccounts.php");
            }
            header("location: ../php/Layout.php");
          }else{
            $log_MSG = $log_MSG."<div class='errorBox'><p>Zure kontua blokeatuta dago</p><p> Administratzailearekin kontaktuan jarri</p> </div>";
          }
        }else{
          $log_MSG = $log_MSG."<div class='errorBox'><p>Kredentzial okerrak</p><p> Berriro Saiatu </p> </div>";
        }

      // Formularioa bete dezala.
      }else{
        echo('<div>
          <form id="galderenF" name="galderenF" enctype="multipart/form-data" method="POST">

            <h2>Zure kontuan sartu</h2>
            <label for="posta">Zure eposta <font color="red">(*)</font></label>
              <input type="text" name="posta" id="posta"><br>

            <label for="pasahitza">Pasahitza <font color="red">(*)</font></label>
              <input type="password" minlength="8" name="pasahitza" id="pasahitza" ><br>

            <input type="submit" name="submitbutton" id="submitbutton" value="Kontuan sartu">
            <input type="reset" name="hustu" id="hustu" value="Hustu"><br>

          </form>
        </div>');
      }
      echo $log_MSG;
    ?>

  </section>
  <?php include "../html/Footer.html" ?>
</body>
</html>
