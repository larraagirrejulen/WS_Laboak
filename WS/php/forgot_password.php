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
  <?php include '../php/DbConfig.php' ?>
  <?php include_once "../php/IncreaseGlobalCounter.php" ?>
  <?php include "../php/Menus.php" ?>
  <section class="main" id="s1">

  <?php if (isset($_POST["posta"])) { ?>

          <h1>baliozko posta</h1>

  <?php }else { ?>
    <form id="forgot_password_form" enctype="multipart/form-data" method="post">
      <h2>Pasahitza ahaztu duzu?</h2>
      <h4>Sar ezazu zure posta elektronikoa pasahitza berrezartzeko</h4>
      <label for="posta">Zure posta <font color="red">(*)</font></label>
        <input type="text" name="posta" id="posta"><br>
      <input type="button" name="submitbutton" id="submitbutton" value="Posta adierazi" onclick="posta_balioztatu()"><br>
    </form>
    <span id="feedback"></span>

  <?php } ?>

  </section>
  <?php include "../html/Footer.html" ?>
</body>
</html>
