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
    <form class="password_refactor" action="PasswordRefactor.php" method="post">

    <?php if (isset($_POST["posta"]) && isset($_POST["pasahitza1"]) && isset($_POST["pasahitza2"])) { ?>

          <?php
            $posta = $_POST['posta'];
            $pasahitza1 = crypt($_POST['pasahitza1'], 'st');
            $pasahitza2 = crypt($_POST['pasahitza2'], 'st');

            if ($pasahitza1 == $pasahitza2) {
              try {
                $dsn = "mysql:host=$zerbitzaria;dbname=$db";
                $dbh = new PDO($dsn, $erabiltzailea, $gakoa);
              } catch (PDOException $e){
                echo $e->getMessage();
              }

              // 1. Prepare
              $stmt=$dbh->prepare("SELECT * FROM users WHERE posta = ?");
              // 2. Bind
              $stmt->bindParam(1, $posta);
              // 3. Excecute
              $stmt->execute();
              $result=$stmt->fetchAll(PDO::FETCH_OBJ);

              if(count($result) == 1){
                ?>
                <h2>Gakoaren aldaketa baieztatu</h2>
                <label for="gakoa">Zure epostara bidalitako gakoa sar ezazu<font color="red">(*)</font></label>
                  <input type="text" name="gakoa" id="gakoa"><br>
                  <input type="text" name="pasahitza" id="pasahitza" value="<?php $pasahitza1 ?>" hidden><br>
                <input type="submit" name="submitbutton" id="submitbutton" value="Pasahitza aldatu">
        <?php }else{
                $log_MSG = $log_MSG."<div class='errorBox'><p>Ez dago posta hori duen konturik</p></div>";
              }
              //konexioa ixteko
              $dbh = null;
            }else {
              $log_MSG = $log_MSG."<div class='errorBox'><p>Pasahitzak ez dira berdinak</p></div>";
            } ?>


    <?php }else if(isset($_POST["gakoa"]) && isset($_POST["pasahitza"])){ ?>

        <?php

          $pasahitza = $_POST["pasahitza"];
          $gakoa

         ?>

        <h2>Pasahitza zuzen aldatu duzu</h2>

    <?php }else{ ?>

        <h2>Zure kontuko pasahitza aldatu</h2>
        <label for="posta">Zure eposta <font color="red">(*)</font></label>
          <input type="text" name="posta" id="posta"><br>
        <label for="pasahitza1">Pasahitz berria <font color="red">(*)</font></label>
          <input type="password" minlength="8" name="pasahitza1" id="pasahitza1" ><br>
        <label for="pasahitza2">Pasahitz berria errepikatu <font color="red">(*)</font></label>
          <input type="password" minlength="8" name="pasahitza2" id="pasahitza2" ><br>
        <input type="submit" name="submitbutton" id="submitbutton" value="Pasahitza aldatu">

    <?php } ?>


    </form>
  </section>
  <?php include "../html/Footer.html" ?>
</body>
</html>
