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

<?php if (isset($_POST["pasahitza1"]) && isset($_POST["pasahitza2"])) {

        $pasahitza1 = crypt($_POST['pasahitza1'], 'st');
        $pasahitza2 = crypt($_POST['pasahitza2'], 'st');

        if ($pasahitza1 == $pasahitza2) { ?>

  <?php }else{
          echo "<div class='errorBox'><p>Pasahitzak ez dira berdinak</p><p>Berrio saiatu</p></div>";
        }

      }elseif (isset($_POST["gakoa"])) {

        session_start();
        $gakoa = $_POST["gakoa"];
        if ($gakoa == $_SESSION["gakoa"]) { ?>
          <h2>Gakoaren aldaketarekin amaitzeko pasahitz berria sartu ezazu</h2>
          <label for="pasahitza1">Pasahitz berria <font color="red">(*)</font></label>
          <input type="password" minlength="8" name="pasahitza1" id="pasahitza1" ><br>
          <label for="pasahitza2">Pasahitz berria errepikatu <font color="red">(*)</font></label>
          <input type="password" minlength="8" name="pasahitza2" id="pasahitza2" ><br>
          <input type="submit" name="submitbutton" id="submitbutton" value="Pasahitza aldatu">
  <?php }else{
          echo "<div class='errorBox'><p>Identifikazio gako okerra</p><p>Berrio saiatu</p></div>";
        }

      }elseif(isset($_POST["posta"])){

        $posta = $_POST["posta"];
        echo "$posta";
        try {
          $dsn = "mysql:host=$zerbitzaria;dbname=$db";
          $dbh = new PDO($dsn, $erabiltzailea, $gakoa);
        } catch (PDOException $e){
          echo $e->getMessage();
        }

        // 1. Prepare
        $stmt=$dbh->prepare("SELECT deitura, mota, irudia, imgdata, egoera FROM users WHERE posta = ?");
        // 2. Bind
        $stmt->bindParam(1, $posta);
        // 3. Excecute
        $stmt->execute();
        $result=$stmt->fetchAll(PDO::FETCH_OBJ);
        echo "$result";
        if(count($result) == 1){
          $rand = mt_rand(100000, 999999);
          create_session();
          $_SESSION["posta"] = $posta;
          $_SESSION["gakoa"] = $rand;
          mail($posta, "Kontuaren pasahitza aldatzeko identifikazio gakoa", "Zure identifikazio gakoa: $rand", "Quiz");
          ?>
          <h2>Zure posta elektronikora bidalitako gakoa sar ezazu</h2>
          <label for="gakoa">Zure gakoa <font color="red">(*)</font></label>
            <input type="text" name="gakoa" id="gakoa"><br>
          <input type="submit" name="submitbutton" id="submitbutton" value="Gakoa balioztatu">
  <?php }else{
          echo "<div class='errorBox'><p>Ez dago posta hori duen konturik</p></div>";
        }

        //konexioa ixteko
        $dbh = null;

      }else{ ?>

        <h2>Zure kontuko posta elektronikoa adierazi ezazu</h2>
        <label for="posta">Zure posta <font color="red">(*)</font></label>
          <input type="text" name="posta" id="posta"><br>
        <input type="submit" name="submitbutton" id="submitbutton" value="Posta adierazi">

<?php } ?>


    </form>
  </section>
  <?php include "../html/Footer.html" ?>
</body>
</html>
