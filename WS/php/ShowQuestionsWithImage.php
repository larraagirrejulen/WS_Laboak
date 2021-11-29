<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <link rel="stylesheet" type="text/css" href="../styles/BoxTypes.css">
  <link rel="stylesheet" type="text/css" href="../styles/Tables.css">
</head>
<body>
  <?php include '../php/Menus.php' ?>
  <?php include '../php/DbConfig.php' ?>
  <section class="main" id="s1">
    <div>
      <?php

        if($logeatuta){
          $dbq = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);

          $sql = "SELECT * FROM questions;";

          if(!$ema=$dbq->query($sql)){
            die('Errorea: '.$dbq->error."<br>");
          }
          echo("<div class='tableContainer'><table class='table'>");
          echo "<thead>";
          echo("<tr>
            <th>Eposta</th>  <th>Galdera</th>
            <th>Zuzen</th> <th>Oker1</th>
            <th>Oker2</th> <th>Oker3</th>
            <th>Zailtasuna</th> <th>Gaia</th> <th>Argazkia</th>
            </tr>");
          echo "</thead>";
          while ($lerroa = $ema -> fetch_assoc()){
            $imgBase64 = array_values($lerroa)[count($lerroa)-2];
            $imgProperties = array_values($lerroa)[count($lerroa)-1];
            $testuBalioak = array_slice($lerroa, 1,count($lerroa)-3,false);


            echo("<tr>");
            echo("<td>".implode("</td><td>", $testuBalioak)."</td>");
            if($imgBase64 != null && $imgProperties != null){
              //$argazkia = "data:".$imgProperties.";base64,$imgBase64";
              $image_path = "../images/questions/".$imgProperties;
              file_put_contents($image_path, base64_decode($imgBase64));
              echo("<td><img src='".$image_path."' width='100px' ></td>");
            }else{
              echo("<td><img src='../images/question_mark.png' width='100px' alt='Ez du irudirik definituta'></td>");
            }

            echo("</tr>");
          }
          echo("</table></div>");
        }else{
          echo("<div class='errorBox'><p>Ezin duzu funtzionalitate hau atzitu logeatuta ez bazaude.</p><p> Logeatu eta saiatu berriro.</p></div> ");
        }
      ?>
    </div>
  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>
