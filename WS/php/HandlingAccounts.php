<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <link rel="stylesheet" type="text/css" href="../styles/BoxTypes.css">
  <link rel="stylesheet" type="text/css" href="../styles/Tables.css">
  <script src='../js/jquery-3.4.1.min.js'> </script>
  <script src='../js/HandlingAccounts.js'> </script>
</head>

<body>
<?php include '../php/DbConfig.php' ?>
  <?php include "../php/Menus.php" ?>

  <section class="main" id="s1">
    <?php
    $log_MSG = "";
    if($logeatuta){
        if($session_mota == "admin"){
            echo "<table class='table'>
                <thead>
                <tr>
                    <th>EPOSTA</th>
                    <th>GAKOA</th>
                    <th>EGOERA</th>
                    <th>IRUDIA</th>
                    <th>PERMUTATU</th>
                    <th>EZABATU</th>
                </tr>
                </thead>
                <tbody>";


                    $dbq = new mysqli($zerbitzaria, $erabiltzailea, $gakoa, $db);

                    $sql = "SELECT posta, pasahitza, egoera, irudia, imgdata, mota FROM users;";

                    if(!$ema=$dbq->query($sql)){
                        die('Errorea: '.$dbq->error."<br>");
                    }

                    while ($lerroa = $ema -> fetch_assoc()){
                      $lerroa = array_values($lerroa);
                      if($lerroa[5] != 'admin'){
                        echo "<tr id='$lerroa[0]'>";
                        echo "<td>$lerroa[0]</td><td>$lerroa[1]</td><td class='egoera'>$lerroa[2]</td>";
                        if($lerroa[3] != null && $lerroa[4] != null){
                          $image_path = "../images/users/".$lerroa[4];
                          file_put_contents($image_path, base64_decode($lerroa[3]));
                          echo("<td><img src='".$image_path."' width='100px' ></td>");
                        }else{
                          echo("<td><img src='../images/question_mark.png' width='100px' alt='Ez du irudirik definituta'></td>");
                        }
                        $egoeraText = "OFF";
                        if($lerroa[2] == 1){
                          $egoeraText = "ON";
                        }
                        echo "<td><input class='egoeraButton' type='button' value='$egoeraText' onclick=\"permutatu('$lerroa[0]')\"/></td>";
                        echo "<td><input type='button' value='Ezabatu' onclick=\"ezabatu('$lerroa[0]')\"/></td>";
                        echo "</tr>";
                      }
                }

                echo "
                </tbody>
            </table>";

    }else{
        $log_MSG = $log_MSG."<div class='errorBox'><p>Ez duzu baimenik honetarako</p><p> Adminsitratzailearekin hitzegin </p> </div>";
    }
}else{
    $log_MSG = $log_MSG."<div class='errorBox'><p>Logeatuta egon behar duzu</p></div>";
}
echo $log_MSG;
?>

    </section>
  <?php include "../html/Footer.html" ?>
</body>
</html>
