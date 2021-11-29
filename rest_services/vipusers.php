<?php

// Datuak eskuratzeko konstanteak ...
require_once 'DbConfig.php';
require_once 'database.php';

$method = $_SERVER['REQUEST_METHOD'];
$resource = $_SERVER['REQUEST_URI'];

    $cnx = Database::Konektatu();
    switch ($method) {
        case 'GET':
           	if(isset($_GET['id'])){
                isVip($cnx, $_GET['id']);
      			}else{
      				// Vipak zerrendatzeko zerbitzua (parametro gabeko GETa)
                getVips($cnx);
      			}
			break;
        case 'POST':
             if (isset($_POST['posta'])) {   // VIPa gehitzeko
               addVip($cnx, $_POST['posta']);
             }
             break;
        case 'PUT':
             // hau ez da inplementatu behar
        case 'DELETE':  // VIP erabiltzailea ezabatzeko
             if(isset($_REQUEST['id'])){
               removeVip($cnx, $_REQUEST['id']);
             }

	}
    Database::Deskonektatu($cnx);

?>

<?php
    function isVip($dbc, $id){
        $sql = "SELECT * FROM vips WHERE vip_posta='$id';";
        echo $sql .' kontsulta exekutatzen dut <p>';
        $data = Database::GauzatuKontsulta($dbc, $sql);
        if (isset($data[0])){
            echo "<br><br><b>ZORIONAK ".$id." VIPa da </b><br>";
        }
        else {
            echo "<br><br><b>SENTITZEN DUT ".$id." Ez da VIPa</b><br>";
        }
    }

    function addVip($dbc, $id){
      if(preg_match("/@(.)+/", $id)){
        $sql = "SELECT * FROM vips WHERE vip_posta = '$id';";
        $data = Database::GauzatuEskalatu($dbc, $sql);
        if($data == null){
          $sql = "INSERT INTO vips VALUES ('$id');";
          $data = Database::GauzatuEzKontsulta($dbc, $sql);
          if($data){ 
            echo "<br>VIP sortua: ".$id;
          }else {
            echo "<br>Ezin izan da VIP-a gehitu: ".$id;
          }
        }else{
          echo "<br>VIP da dagoeneko: ".$id;
        }
      }else{
        echo "<br>Errorea, postaren egitura egokia dela zihurtatu ( @(.)+ ): ".$id;
      }
    }

    function removeVip($dbc, $id){
      $sql = "DELETE FROM vips WHERE vip_posta='$id';";
      $data = Database::GauzatuEzKontsulta($dbc, $sql);
      if($data==0){
        echo "<br>Ez dago helbide elektronikoa: ".$id;
      }else {
        echo "<br>Deleted row: ".$id;
      }
    }

    function getVips($dbc){
        $sql = "SELECT * FROM vips";

        $data = Database::GauzatuKontsulta($dbc, $sql);
        echo "<div id=vips>";
        if($data != ""){
            echo $data;
        }else{
            echo "Ez dago vip bezerorik";
        }

        echo "</div>";
    }
?>
