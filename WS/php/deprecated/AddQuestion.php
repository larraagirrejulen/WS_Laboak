<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
</head>
<body>
  <?php include '../php/Menus.php' ?>
  <section class="main" id="s1">
    <div>
    <?php include '../php/DbConfig.php' ?>
      <!-- Funtzioak definitu -->
      <?php
        function frogatuOndo ($pUposta, $pTgaldera, $pEzuzena, $pEokerra1, $pEokerra2, $pEokerra3, $pZailtasun, $pGarloa) {
          $ondo = 0;
          if (preg_match("/^[A-Za-z]+\d{3}@ikasle\.ehu\.(eus|es)$/", $pUposta) || preg_match("/^[A-Za-z]+\.?[A-Za-z]*@ehu\.(eus|es)$/", $pUposta)){
            if (strlen($pTgaldera) >= 10){
              if(strlen($pEzuzena)>0 && strlen($pEokerra1)>0 && strlen($pEokerra2)>0 && strlen($pEokerra3)>0 && strlen($pZailtasun)>0 && strlen($pGarloa)>0){
                $ondo = 1;
              }
            }
          }
          return $ondo;
        }
      ?>

      <!-- MAIN-a definitu -->
      <?php

        $aldagIzenak = array("uposta","tgaldera","ezuzena", "eokerra1", "eokerra2", "eokerra3", "zailtasun", "gArloa");
        
        $ok = 1;
        for($i=0; $ok && $i<count($aldagIzenak); $i=$i+1){
          $ok = $ok && array_key_exists($aldagIzenak[$i], $_POST);
        }  

        if ($ok){
          $uposta = $_POST["uposta"];
          $tgaldera = $_POST["tgaldera"];
          $ezuzena = $_POST["ezuzena"];
          $eokerra1 = $_POST["eokerra1"];
          $eokerra2 = $_POST["eokerra2"];
          $eokerra3 = $_POST["eokerra3"];
          $zailtasun = $_POST["zailtasun"];
          $gArloa = $_POST["gArloa"];          

          $ok = frogatuOndo($posta, $tgaldera, $ezuzena, $eokerra1, $eokerra2, $eokerra3, $zailtasun, $gArloa);
          
          if($ok){
            $dbq = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);
      
            $sql = "INSERT INTO questions (eposta, galdera, eZuzen, eOker1, eOker2, eOker3, zailtasun, gaia) VALUES ('$uposta', '$tgaldera', '$ezuzena', '$eokerra1', '$eokerra2', '$eokerra3', $zailtasun, '$gArloa')";
              
            echo("<br>");
    
            if(!$dbq->query($sql)){
              echo('Errorea: '.$dbq->error."<br>");
              $ok=0;
            }
          }
        }
            
       
        if($ok){
          echo("Datuak ondo gorde dira datu basean <br>");
          echo("Beste galdera bat gehitzeko ");
        }else {
          echo("Ezin izan da galdera datu basean gorde <br>");
          echo("Berriro saiatzeko ");
        }
        echo("<a href='./QuestionForm.php'>hemen sakatu</a> <br> <br>");
        echo("Irudirik gabeko galderak ikusteko <a href='./ShowQuestions.php'>hemen sakatu</a> <br>");
        echo("Irudiak dituzten galderak ikusteko <a href='./ShowQuestionsWithImage.php'>hemen sakatu</a> <br>");
        
      ?>
    </div>
  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>
