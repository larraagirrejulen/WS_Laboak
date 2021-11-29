
<?php include_once '../php/CaptureLoginInfo.php'?>
<?php include '../php/DbConfig.php'?>
<script src='../js/jquery-3.4.1.min.js'> </script>
<script src='../js/LogedUserCount.js'></script>
<div id='page-wrap'>
  <header class='main' id='h1'>
    <style>
      .avatar{
        border-radius: 50%;
        border: 0.5px solid lightgray;
      }
      .left,.center,.right, .superleft{
        display: inline-block;
        vertical-align: middle;
      }
      .center{
        margin: 0px 10px;
      }
      .left p{
        text-align: right;
        font-style: italic;
      }
      .superleft{
        float: left;
        text-align: left;
      }
    </style>
    <?php
      // Logeatuta dagoen ikusi (CaptureLoginInfo erabiliz)
      if(!$logeatuta){
        echo('<span><a href="SignUp.php">Erregistratu</a></span>
        <span><a href="LogIn.php">Login</a></span>');
      }else{

        // DBtik erabiltzailearen gainontzeko informazioa eskuratu.
        $dbq = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);
        $sql = "SELECT deiturak, irudia, imgdata FROM users WHERE posta='$session_posta';";
        if(!$ema = $dbq->query($sql)){
          die("Errorea datuak jasotzerakoen db-tik: ".$dbq->error."<br>");
        }

        // Erabiltzailea existitzen dela ziurtatu
        if(mysqli_num_rows($ema) > 0){
          $emaitzak = mysqli_fetch_row($ema);
          $deiturak = $emaitzak[0];
          $imgBase64 = $emaitzak[1]; //Argazkia blob base 64
          $imgProperties = $emaitzak[2]; //Argazkiaren formatua

          // Eskuratutako datuak pantailaratu.
          echo "<div class='superleft'>Kautotutako <br> erabiltzaile  kopurua: <span class='usercounter'>?</span></div>";
          echo('<div class="left"><p>'.$session_posta);

          echo('</p><p>'.$deiturak.'</p></div> <div class="center">');
          if($imgBase64 != null && $imgProperties != null){
            $format = explode(-1, $imgProperties);
            $format = $format[count($format)-1];
            $argazkia = "data:image/".$format.";base64,$imgBase64";
            echo("<img class='avatar' src='".$argazkia."' width='40px' height='40px'>");
          }else{
            echo("<img class='avatar' src='../images/question_mark.png' width='40px' height='40px' alt='Ez du irudirik definituta'>");
          }
          echo('</div><div class="right"><br><a href="LogOut.php">Logout</a></div>');

        }
      }

    ?>
  </header>


  <nav class='main' id='n1' role='navigation'>
    <style type="text/css">
      .links{
        margin-left: 60px;
        text-align: left;
      }
    </style>
    <div class='links'>
      <?php
      echo("<span><a href='Layout.php'>Hasiera</a></span>");
      if($logeatuta){
        if($session_mota == "ikasle" || $session_mota == "irakasle"){
          echo "<span><a href='HandlingQuizesAjax.php'>Galderak kudeatu</a></span> <br>";
        }
        if($session_mota == "irakasle"){
          echo " <span><a href='IsVip.php'>VIPa da?</a></span> <br>
          <span><a href='ShowVips.php'>VIPak zerrendatu</a></span> <br>
          <span><a href='AddVip.php'>VIPa gehitu</a></span> <br>
          <span><a href='DeleteVip.php'>VIPa ezabatu</a></span> <br>
          ";
        }
        if($session_mota == "admin"){
          echo "<span><a href='HandlingAccounts.php'>Erabiltzaileak kudeatu </a></span> <br>";
        }

      }
      echo("<span><a href='Credits.php'>Kredituak</a></span>");

      ?>
    </div>
  </nav>
