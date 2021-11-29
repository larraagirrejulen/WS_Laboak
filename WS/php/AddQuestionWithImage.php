<!-- <!DOCTYPE html> -->
<html>
<head>
  <?php include '../html/Head.html'?>
  <link rel="stylesheet" type="text/css" href="../styles/BoxTypes.css">
</head>
<body>
  <?php include '../php/Menus.php' ?>
  <section class="main" id="s1">
    <div>
    <?php include '../php/DbConfig.php' ?>

      <!-- Funtzioak definitu -->
      <?php
        function frogatuOndo ($pTgaldera, $pEzuzena, $pEokerra1, $pEokerra2, $pEokerra3, $pZailtasun, $pGarloa) {
          if (strlen($pTgaldera) >= 10){
            if(strlen($pEzuzena)>0 && strlen($pEokerra1)>0 && strlen($pEokerra2)>0 && strlen($pEokerra3)>0 && strlen($pZailtasun)>0 && strlen($pGarloa)>0){
              if(4 > $pZailtasun && $pZailtasun > 0){
                return 1;
              }
            }
          }
          return 0;
        }
        function hutsuneEzErabilgKendu($pText){
          $strOK = preg_replace('/\s{2,}/', ' ', $pText);
          $strOK = preg_replace('/^\s+/', '', $strOK);
          $strOK = preg_replace('/\s+$/', '', $strOK);
          return $strOK;
        }
      ?>


      <!-- MAIN-a definitu -->
      <?php
        if($logeatuta && ($session_mota == "ikasle" || $session_mota == "irakasle")){
          $aldagIzenak = array("tgaldera","ezuzena", "eokerra1", "eokerra2", "eokerra3", "zailtasun", "gArloa");
          $argazkiTag = "fileName";

          // Frogatu indize guztiak bidali direla eta $aldagIzenak array-ean dauden izen berdinak dituztela.
          $ok = 1;
          $okXml = 0;
          $okJson = 0;
          for($i=0; $ok && $i<count($aldagIzenak); $i=$i+1){
            $ok = $ok && array_key_exists($aldagIzenak[$i], $_POST);
          }
            if ($ok){
            $tgaldera = hutsuneEzErabilgKendu($_POST["tgaldera"]);
            $ezuzena = hutsuneEzErabilgKendu($_POST["ezuzena"]);
            $eokerra1 = hutsuneEzErabilgKendu($_POST["eokerra1"]);
            $eokerra2 = hutsuneEzErabilgKendu($_POST["eokerra2"]);
            $eokerra3 = hutsuneEzErabilgKendu($_POST["eokerra3"]);
            $zailtasun = $_POST["zailtasun"];
            $gArloa = hutsuneEzErabilgKendu($_POST["gArloa"]);

            $argazkiaDago = array_key_exists($argazkiTag, $_FILES) && $_FILES[$argazkiTag]["error"] == 0;

            $ok = frogatuOndo($tgaldera, $ezuzena, $eokerra1, $eokerra2, $eokerra3, $zailtasun, $gArloa);

            if($ok){
              // Galdera datu basean gorde
              $dbq = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);

              if($argazkiaDago){
                $imageProperties = $_FILES["$argazkiTag"]['name'];
                $imgData = base64_encode(file_get_contents($_FILES[$argazkiTag]['tmp_name']));
                $sql = "INSERT INTO questions (eposta, galdera, eZuzen, eOker1, eOker2, eOker3, zailtasun, gaia, argazkia, imgdata)
                VALUES ('$session_posta', '$tgaldera', '$ezuzena', '$eokerra1', '$eokerra2', '$eokerra3', '$zailtasun', '$gArloa', '$imgData', '".$imageProperties."');";
              }else{
                $sql = "INSERT INTO questions (eposta, galdera, eZuzen, eOker1, eOker2, eOker3, zailtasun, gaia) VALUES ('$session_posta', '$tgaldera', '$ezuzena', '$eokerra1', '$eokerra2', '$eokerra3', '$zailtasun', '$gArloa');";
              }

              if(!$ema=$dbq->query($sql)){
                die('Errorea frogaketan: '.$dbq->error."<br>");
              }

              // XML-n gehitu
              $okXml = 1;
              try {
                $xml = simplexml_load_file('../xml/Questions.xml');
                  $assessmentItem = $xml->addChild('assessmentItem');
                  $assessmentItem -> addAttribute('author', $session_posta);
                  $assessmentItem -> addAttribute('subject', $gArloa);
                    $itemBody = $assessmentItem->addChild('itemBody');
                      $itemBody -> addChild('p', $tgaldera);
                    $correctResponse = $assessmentItem -> addChild('correctResponse');
                      $correctResponse->addChild('response', $ezuzena);
                    $incorrectResponse = $assessmentItem -> addChild('incorrectResponse');
                      $incorrectResponse->addChild('response', $eokerra1);
                      $incorrectResponse->addChild('response', $eokerra2);
                      $incorrectResponse->addChild('response', $eokerra3);

                $domxml = new DOMDocument('1.0');
                $domxml->preserveWhiteSpace = false;
                $domxml->formatOutput = true;
                /* @var $xml SimpleXMLElement */
                $domxml->loadXML($xml->asXML());
                $domxml->save('../xml/Questions.xml');
              } catch (Exception $e){
                $okXml = 0;
              }
              echo("<br>");

              // JSON
              $okJson = 1;
              try {
                $jSonData = file_get_contents('../json/Questions.json');
                $jSon = json_decode($jSonData);
                $jGaldera = new stdClass();
                $jGaldera->subject=$gArloa;
                $jGaldera->author=$session_posta;
                $jGaldera->itemBody = array('p' => $tgaldera);
                $jGaldera->correctResponse = array('response' => $ezuzena);
                $jGaldera->incorrectResponses = array(
                  'response' => array($eokerra1, $eokerra2, $eokerra3)
                );

                array_push($jSon->assessmentItems, $jGaldera);
                $jSonData = json_encode($jSon, JSON_PRETTY_PRINT);
                file_put_contents("../json/Questions.json",$jSonData);

              } catch (Exception $e){
                $okJson = 0;
              }
            }
          }
       echo "<div id='status'>";
          if($ok){
            echo("<div class='okBox'>Datuak ondo gorde dira datu basean</div>");
          }else {
            echo("<div class='errorBox'>Ezin izan da galdera datu basean gorde</div>");
          }
          if($okXml){
            echo("<div class='okBox'>Datuak ondo gorde dira XML-an</div>");
          }else {
            echo("<div class='errorBox'>Ezin izan da galdera XML-an gorde</div>");
          }
          if($okJson){
            echo("<div class='okBox'>Datuak ondo gorde dira JSON-ean</div>");
          }else {
            echo("<div class='errorBox'>Ezin izan da galdera JSON-ean gorde</div>");
          }
       echo "</div>";
          if($ok && $okXml && $okJson){
            echo "Guztia ondo joan da. Beste galdera bat gehitzeko ";
          }else{
            echo "Erroreak egon dira. Berriro saiatzeko ";
          }
          echo("<a href='./QuestionFormWithImage.php'>hemen sakatu</a> <br> <br>");
          echo("Galderak ikusteko <a href='./ShowQuestionsWithImage.php'>hemen sakatu</a> <br>");

        }else{
          echo("<div class='errorBox'><p>Ezin duzu funtzionalitate hau atzitu logeatuta ez bazaude.</p><p> Logeatu eta saiatu berriro.</p></div> ");
        }

      ?>
    </div>
  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>
