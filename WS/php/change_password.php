<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <link rel="stylesheet" type="text/css" href="../styles/BoxTypes.css">
  <script src="../js/forgot_password.js"></script>
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
  <?php include "../php/Menus.php" ?>
  <section class="main" id="s1">

<?php if(isset($_POST["pasahitza1"]) && isset($_POST["pasahitza2"]) && isset($_POST["posta"]) && isset($_POST["token"])){

        $posta = $_POST["posta"];
        $token = crypt($_POST["token"], '$1$somethin$');
        $pasahitza = crypt($_POST["pasahitza1"], '$1$somethin$');

        if(is_null($token) || $token == ""){
          exit();
        }

        try {
          $dsn = "mysql:host=$zerbitzaria;dbname=$db";
          $dbh = new PDO($dsn, $erabiltzailea, $gakoa);
        } catch (PDOException $e){
          echo $e->getMessage();
        }

        // 1. Prepare
        $stmt = $dbh->prepare("UPDATE users SET pasahitza=?, gakoa=NULL WHERE posta=? AND gakoa=?");

        // 2. Bind
        $stmt->bindParam(1, $pasahitza);
        $stmt->bindParam(2, $posta);
        $stmt->bindParam(3, $token);

        // 3. Excecute
        if($stmt->execute()){
          echo "<div class='okBox'><p>Pasahitza zuzen aldatu da</p></div>";
        }else{
          echo "<div class='errorBox'><p>Errorea pasahitza aldatzean</p></div>";
        }

        //konexioa ixteko
        $dbh = null;

      }elseif (isset($_GET["token"]) && isset($_GET["email"])) {

        $token = $_GET["token"];
        $posta = $_GET["email"];

        if(is_null($token) || $token == ""){
          exit();
        }

        ?>
        <form enctype="multipart/form-data" method="post" onsubmit="return pasahitza_balioztatu();" action="change_password.php">
          <h2>Pasahitza aldatu</h2>
          <h4>Sar ezazu zure pasahitz berria</h4>
          <label for="pasahitza1">Zure pasahitz berria</label>
          <input type="password" minlength="8" name="pasahitza1" id="pasahitza1"><br>
          <label for="pasahitza2">Pasahitz berria errepikatu</label>
          <input type="password" minlength="8" name="pasahitza2" id="pasahitza2"><br>
          <?php
          echo "<input type='text' name='posta' id='posta' value='$posta' hidden>
                  <input type='text' name='token' id='token' value='$token' hidden>";
          ?>
          <input type='submit' name='button' id='button' value='Pasahitza aldatu'> <br>
        </form>
        <span id="feedback"></span>

<?php } ?>

    <span id="feedback"></span>

  </section>
  <?php include "../html/Footer.html" ?>
</body>
</html>
