<?php
  function matrikulaEgiaztatu($posta)
  {
    $soapclient = new SoapClient('http://ehusw.es/rosa/webZerbitzuak/egiaztatuMatrikula.php?wsdl');
    $result = $soapclient->egiaztatuE($posta);
    if ($result == "BAI") {
      return 1;
    }else {
      return 0;
    }
  }

  if(isset($_POST['posta'])){
    echo matrikulaEgiaztatu($_POST['posta']);
  }
 ?>
