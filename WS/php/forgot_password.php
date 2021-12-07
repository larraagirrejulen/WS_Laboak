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

<?php if (isset($_POST["posta"])) {

        $posta = $_POST["posta"];
        $balioztatze_gakoa = mt_rand(100000, 999999);

        $url = $path."change_password.php?token=$balioztatze_gakoa&email=$posta";

        $balioztatze_gakoa = crypt($balioztatze_gakoa, '$1$somethin$');

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

        mail($posta, "Pasahitza aldatu", "Emen duzu zure Quiz kontuko pasahitza aldatzeko linka:
                      "."$url", "From: Quiz account handler");

        echo "<div class='okBox'><p>Mezu bat bidali dizugu zure posta elektronikora,
        pasahitza aldatzeko link batekin. <br> Baliteke ordu bat edo batzuk behar izatea mezua iristeko.
        <br> Horrialdea itxi dezakezu nahi baduzu.</p></div>";

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
