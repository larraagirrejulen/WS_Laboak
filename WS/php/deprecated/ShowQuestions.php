<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <style type='text/css'>
    th{
      margin: 10px;
      padding: 10px;
    }
    #taulaResp{
      padding: 10px;
      border-style: solid;
      border-width: 2px;
      border-color: black;
      margin-left: auto;
      margin-right: auto;
      border-style: solid;
      border-width: 2px;
      border-color: black;
    }
  </style>
</head>
<body>
  <?php include '../php/Menus.php' ?>
  <section class="main" id="s1">
  <?php include '../php/DbConfig.php' ?>
    <div>
      <?php
        $dbq = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);

        $sql = "SELECT eposta, galdera, eZuzen, eOker1, eOker2, eOker3, zailtasun, gaia FROM questions;";

        if(!$ema=$dbq->query($sql)){
          die('Errorea: '.$dbq->error."<br>");
        }
        echo("<table id='taulaResp'>");
        echo("<tr>
          <th>Eposta</th>  <th>Galdera</th>
          <th>Zuzen</th> <th>Oker1</th> 
          <th>Oker2</th> <th>Oker3</th> 
          <th>Zailtasuna</th> <th>Gaia</th>
          </tr>");
        while ($lerroa = $ema -> fetch_assoc()){
          echo("<tr>");
          echo("<td>".implode("</td><td>", $lerroa)."</td>");
          echo("</tr>");
        }
        echo("</table>");

      ?>
    </div>
  </section>
  <?php include '../html/Footer.html' ?>
</body>

</html>
