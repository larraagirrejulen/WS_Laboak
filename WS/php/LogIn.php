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
        $pasahitza = crypt($_POST['pasahitza'], 'st');

        try {
          $dsn = "mysql:host=$zerbitzaria;dbname=$db";
          $dbh = new PDO($dsn, $erabiltzailea, $gakoa);
        } catch (PDOException $e){
          echo $e->getMessage();
        }

        // 1. Prepare
        $stmt=$dbh->prepare("SELECT deiturak, mota, irudia, imgdata, egoera FROM users WHERE posta = ?");
        // 2. Bind
        $stmt->bindParam(1, $posta);
        // 3. Excecute
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_OBJ);

        if(count($result) == 1){
          $result = $result[0];
          if($result->egoera == 1){
            $deiturak = $result->deiturak;
            $mota = $result->mota;
            $img_data = $result->irudia; //Argazkia blob base 64
            $img_name = $result->imgdata; //Argazkiaren formatua

            $log_MSG = $log_MSG."Kredentzial egokiak <br> <br>";
            $log_MSG = $log_MSG."<h1> Ongi Etorri '$deiturak' </h1>";

            $_SESSION['posta'] = $posta;
            $_SESSION['mota'] = $mota;
            erabUserCounterGehitu($posta);
            if($img_data != null && $img_name != null){
              $img_path = "../images/users/".$img_name;
            }else{
              $img_path = "../images/question_mark.png";
            }
            file_put_contents($img_path, base64_decode($img_data));
            $_SESSION['img'] = $img_path;

            header("location: ../php/Layout.php");

          }else{
            $log_MSG = $log_MSG."<div class='errorBox'><p>Zure kontua blokeatuta dago</p><p> Administratzailearekin kontaktuan jarri</p> </div>";
          }

        }else{
          $log_MSG = $log_MSG."<div class='errorBox'><p>Kredentzial okerrak</p><p> Berriro Saiatu </p> </div>";
        }
      }

      //konexioa ixteko
      $dbh = null;

      echo('<div>
        <form id="galderenF" name="galderenF" enctype="multipart/form-data" method="POST">

          <h2>Zure kontuan sartu</h2>
          <label for="posta">Zure eposta <font color="red">(*)</font></label>
            <input type="text" name="posta" id="posta"><br>

          <label for="pasahitza">Pasahitza <font color="red">(*)</font></label>
            <input type="password" minlength="8" name="pasahitza" id="pasahitza" ><br>

          <input type="submit" name="submitbutton" id="submitbutton" value="Kontuan sartu">
          <input type="reset" name="hustu" id="hustu" value="Hustu"><br>

          <br><a href="../php/forgot_password.php">Pasahitza ahaztu duzu?</a>

        </form>
      </div>');
      echo $log_MSG;
    ?>

  </section>
  <?php include "../html/Footer.html" ?>
</body>
</html>
