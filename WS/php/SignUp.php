<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <link rel="stylesheet" type="text/css" href="../styles/BoxTypes.css">
  <script src='../js/jquery-3.4.1.min.js'> </script>
  <script src='../js/ValidateEnrol.js'></script>
  <style type="text/css">
    #galderenF label, input{
      margin-bottom: 2px;
      margin-top: 2px;
      margin-right: 4px;
      vertical-align: middle;
    }
    #galderenF{
      margin-left: 50px;
      text-align: left;
    }
    #galderenF h2{
      margin-bottom: 4px;
    }
  </style>
</head>

<body>
  <?php include '../php/Menus.php' ?>
  <?php include '../php/DbConfig.php' ?>
  <?php include '../php/ClientVerifyEnrollment.php' ?>

  <section class="main" id="s1"> <!-- section ez da existitzen HTML4 an -->

  <?php
    function frogatuOndo ($mota, $eposta, $deitura, $pasahitza1, $pasahitza2) {
      $ondo = 0;
      $error_log = "";
      if ((!strcmp($mota,"ikasle") && preg_match("/^[A-Za-z]+\d{3}@ikasle\.ehu\.(eus|es)$/", $eposta)) || (!strcmp($mota,"irakasle") && preg_match("/^[A-Za-z]+\.?[A-Za-z]*@ehu\.(eus|es)$/", $eposta))){
        if (preg_match("/^([A-Za-z]+\s){1,4}[A-Za-z]+$/", $deitura)){
          if(!strcmp($pasahitza1, $pasahitza2) && strlen($pasahitza1)>0 && preg_match("/^[^\s]*$/", $pasahitza1)){
            if (matrikulaEgiaztatu($eposta)) {
              $ondo = 1;
            }else {
              $error_log = $error_log."<div class='errorBox'><p>WS irakasgaian matrikulatuta egon behar duzu!</p></div>";
            }
          }else{
            $error_log = $error_log."<div class='errorBox'><p>Pasahitzak ez daude ondo.</p><p> Ez dira berdinak edo luzeera gutxikoak (<8) eta hutsunerik gabe</p></div>";
          }
        }else{
          $error_log = $error_log."<div class='errorBox'><p>Izena eta Abizenak txarto.<p></p> Minimo abizen bat jarri behr dira hutsune batekin banatuta</p></div>";
        }
      }else{
        $error_log = $error_log."<div class='errorBox'>Posta ez da egokia</div>";
      }

      return array($ondo, $error_log);
    }
  ?>

  <?php
    $argazkiTag = "fileName";
    $log_MSG = "";
    $ok = 0;
    if(isset($_POST['mota'])){

      // Balio guztiak ezarrita dauden ikusi.
      $aldagIzenak = array("eposta", "deitura", "pasahitza1", "pasahitza2");
      $ok = 1;
      for($i=0; $ok && $i<count($aldagIzenak); $i=$i+1){
        $ok = $ok && array_key_exists($aldagIzenak[$i], $_POST);
      }

      if ($ok){

        // Balio guztiak lortu eta ongi dauden ikusi.
        $mota = $_POST['mota'];
        $eposta = $_POST["eposta"];
        $deitura = $_POST["deitura"]; // Izen eta abizena
        $pass1 = $_POST["pasahitza1"];
        $pass2 = $_POST["pasahitza2"];
        $ema_frogOndo = frogatuOndo($mota, $eposta, $deitura, $pass1, $pass2);
        $ok = $ema_frogOndo[0];
        $log_MSG = $log_MSG.$ema_frogOndo[1];

        if($ok){

          // Erabiltzailea ez dela existitzen eta errorerik ez dela sortzen ziurtatu.
          $ok=0;
          $dbq = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);
          $sql = "SELECT posta FROM users WHERE posta='$eposta';";
          if(!$ema=$dbq->query($sql)){
            echo('Errorea posta erregistraturik badagoen frogaketa: '.$dbq->error."<br>");
          }else if(mysqli_num_rows($ema) == 0){
            $pass1 = crypt($pass1, 'st'); //Zifraketa
            // Argazkia ere adierazi bada, hori ere kontuan izan datuak DBan txertatzeko.
            if(array_key_exists($argazkiTag, $_FILES) && $_FILES[$argazkiTag]["error"] == 0){
              $imageProperties = $_FILES[$argazkiTag]['name'];
              $imgData = base64_encode(file_get_contents($_FILES[$argazkiTag]['tmp_name']));
              $sql = "INSERT INTO users (posta, deiturak, pasahitza, irudia, imgdata, mota, egoera) VALUES ( '$eposta', '$deitura', '$pass1', '$imgData', '$imageProperties', '$mota', 1);";
            }else{
              $sql = "INSERT INTO users (posta, deiturak, pasahitza, mota, egoera) VALUES ( '$eposta', '$deitura', '$pass1' , '$mota', 1);";
            }

            // Feedback itzuli.
            if(!$dbq->query($sql)){
              echo('Errorea insert: '.$dbq->error."<br>");
            }else{
              $log_MSG = $log_MSG."<div class='okBox'>Era egokian erregistratu zara</div>";
              $ok=1;
            }
          }else{
            $log_MSG = $log_MSG."<div class='warningBox'><p>Dagoeneko posta hori erregistratuta dago.</p><p> Beste posta batekin saiatu.</p></div>";
          }
        }
      }
    }

    // Formularioa.
    if (!$ok) {
      echo '<div>
      <form id="galderenF" name="galderenF" enctype="multipart/form-data" method="POST" action="SignUp.php">
       <h2>Erregistratu</h2>
       <label for="mota">Erabiltzaile mota <font color="red">(*)</font></label>
         <input type="radio" name="mota" id="irakasle" value="irakasle"> <label for="irakasle">Irakaslea</label>
         <input type="radio" name="mota" id="ikasle" value="ikasle"> <label for="ikasle">Ikaslea</label><br>
         <span id="posta_container">
           <label for="eposta">Zure eposta <font color="red">(*)</font></label>
             <input type="text" name="eposta" id="eposta" onchange="validateEnrol()">
         </span><br>
       <label for="deitura">Izen Abizenak <font color="red">(*)</font></label>
         <input type="text" name="deitura" id="deitura" ><br>
       <label for="pasahitza1">Pasahitza <font color="red">(*)</font></label>
         <input type="password" minlength="8" name="pasahitza1" id="pasahitza1"><br>
       <label for="pasahitza2">Pasahitza errepikatu <font color="red">(*)</font></label>
         <input type="password" name="pasahitza2" id="pasahitza2" ><br>
       <label for="gIrudia"> Zure irudia:</label><br>
          <input name="fileName" type="file" id="gIrudia"/><br>
      <input type="submit" name="submitbutton" id="submitbutton" value="Erregistratu">
       <input type="reset" name="hustu" id="hustu" value="Hustu"><br>

       <!-- <img src="" id="irudia" width=200px> -->
      </form>
      </div>';
    }
    echo $log_MSG;
  ?>



  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>