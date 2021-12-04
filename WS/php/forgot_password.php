<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <link rel="stylesheet" type="text/css" href="../styles/BoxTypes.css">
  <script src="../js/verify.js"></script>
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
  <?php include_once "../php/IncreaseGlobalCounter.php" ?>
  <?php include "../php/Menus.php" ?>
  <section class="main" id="s1">

<?php if (isset($_POST["balioztatze_gakoa"]) && isset($_SESSION["posta"])) {

        $posta = $_SESSION["posta"];
        $balioztatze_gakoa = $_POST["balioztatze_gakoa"];

        echo "<form id='change_password_form'>
           <h2>Pasahitza aldatu</h2>
           <h4>Sar ezazu zure pasahitz berria</h4>
           <label for='pasahitza1'>Zure pasahitz berria</label>
             <input type='password' minlength='8' name='pasahitza1' id='pasahitza1'></br>
           <label for='pasahitza2'>Pasahitz berria errepikatu</label>
             <input type='password' minlength='8' name='pasahitza2' id='pasahitza2'></br>
           <input type='submit' name='submitbutton' id='submitbutton' value='Pasahitzak sartu' onclick='pasahitza_eguneratu(".$posta.", ".$balioztatze_gakoa.")'></br>
        </form>";

      }elseif (isset($_POST["posta"])) {

        $posta = $_POST["posta"];
        $balioztatze_gakoa = mt_rand(100000, 999999);

        $balioztatze_gakoa = 999999;

        $_SESSION["posta"] = $posta;

        try {
          $dsn = "mysql:host=$zerbitzaria;dbname=$db";
          $dbh = new PDO($dsn, $erabiltzailea, $gakoa);
        } catch (PDOException $e){
          echo $e->getMessage();
        }

        // 1. Prepare
        $stmt = $dbh->prepare("UPDATE users SET gakoa=? WHERE posta=?");

        // 2. Bind
        $stmt->bindParam(1, $balioztatze_gakoa);
        $stmt->bindParam(2, $posta);

        // 3. Excecute
        if(!$stmt->execute()){
          echo "<div class='errorBox'><p>Errorea DBa atzitzean</p></div>";
        }

        //konexioa ixteko
        $dbh = null;

      //  mail($posta, "Balioztatze gakoa", "Zure kontuaren pasahitza aldatu ahal izateko gakoa,
      //                honakoa da: "."$balioztatze_gakoa", "From: Quiz account handler");


        echo "<form enctype='multipart/form-data' method='post' onsubmit='return gakoa_balioztatu($balioztatze_gakoa);' action='forgot_password.php'>
          <h2>Identitatea balioztatu</h2>
          <h4>Sar ezazu zure posta elektronikora bidalitako gakoa zeure burua identifikatzeko</h4>
          <label for='balioztatze_gakoa'>Gakoa</label>
            <input type='text' name='balioztatze_gakoa' id='balioztatze_gakoa'><br>
          <input type='submit' name='submitbutton' id='submitbutton' value='Gakoa balioztatu'><br>
        </form>";

      }else {?>

        <form enctype="multipart/form-data" method="post" onsubmit="return posta_balioztatu();" action="forgot_password.php">
          <h2>Pasahitza ahaztu duzu?</h2>
          <h4>Sar ezazu zure posta elektronikoa pasahitza berrezartzeko</h4>
          <label for="posta">Zure posta</label>
            <input type="text" name="posta" id="posta"><br>
          <input type="submit" name="submitbutton" id="submitbutton" value="Posta sartu"><br>
        </form>

<?php } ?>

    <span id="feedback"></span>

  </section>
  <?php include "../html/Footer.html" ?>
</body>
</html>
