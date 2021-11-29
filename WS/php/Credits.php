<!DOCTYPE html>
<html>
<head>
  <?php include '../html/Head.html'?>
  <link rel="stylesheet" type="text/css" href="../styles/Tables.css">
  <script src="../js/jquery-3.4.1.min.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
  <style>
    #map {
      display: block;
      height: 400px;
      width: 500px;
      margin: 0em auto;
    }

  </style>

</head>

<body>
  <?php include '../php/Menus.php' ?>
  <section class="main" id="s1">
      <table class="table">
        <caption>EGILEEN DATUAK</caption>
        <thead>
          <tr>
            <th>DEITURAK</th>
            <th>ESPEZIALITATEA</th>
            <th>UDALERRIA</th>
            <th>AVATAR</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Mikel Laorden</td><td>Software ingenieritza</td>
            <td>Arrigorriaga</td><td><img src="../images/gato2.jpg" height="120px"></td>
          </tr>
          <tr>
            <td>Julen Larrañaga</td><td>Software ingenieritza</td>
            <td>Belauntza</td><td><img src="../images/gato1.jpg" width="120px"></td>
          </tr>
        </tbody>
      </table>
      <br>
      <?php
        $zerbLoc = getLatLonJson($_SERVER["SERVER_ADDR"]);
        $bezLoc = getLatLonJson($_SERVER["REMOTE_ADDR"]);

        $concatZerbLoc = implode(",", $zerbLoc);
        $concatBezLoc = implode(",", $bezLoc);

        echo "Client location: ".$concatBezLoc;
        echo "Server location: ".$concatZerbLoc;
      ?>
      <div id="map"></div>

      <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
      <script>
        var mymap = L.map('map').setView([0, 0], 1);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mymap);

        var markerServ = L.marker([<?php echo $concatZerbLoc;?>]).addTo(mymap);
        markerServ.bindPopup("<b>Zerbitzaria</b>").openPopup();

        var markerClient = L.marker([<?php echo $concatBezLoc;?>]).addTo(mymap);
        markerClient.bindPopup("<b>Bezeroa</b><br>Kokapen hurbildua").openPopup();

        var group = new L.featureGroup([markerServ, markerClient]);

        mymap.fitBounds(group.getBounds());
        mymap.setZoom(mymap.getZoom()-1);

      </script>

  </section>
  <?php include '../html/Footer.html' ?>
</body>
</html>

<?php
  function getLatLonJson($ip){
    $curl = curl_init();
    $url = "http://ip-api.com/json/".$ip."?fields=status,lat,lon,query";

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $res = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);
    if (!$res || $httpCode >= 400){
            return array(0,0);
    }

    $locData = json_decode($res, true);
    if (isset($locData["status"]) && $locData["status"] == "success"){
            return array($locData["lat"], $locData["lon"]);
    }
    return array(0,0);
  }
?>
