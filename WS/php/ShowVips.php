<!-- <!DOCTYPE html> -->
<html>
<head>
    <?php include '../html/Head.html'?>
    <link rel="stylesheet" type="text/css" href="../styles/BoxTypes.css">
</head>
<body>
    <?php include '../php/Menus.php' ?>
    <?php include '../php/RestServiceConstants.php' ?>

    <section class="main" id="s1">
    <div>
    <?php
        if($logeatuta){

            if ($session_mota == "irakasle") {

                echo "<h2>Uneko VIPak zerrendatzeko REST bezeroa</h2><br>";
                echo "<h3>Hauek dira VIP erabiltzaileak:</h3><br>";

                $curl = curl_init();
                $restServiceUrl = "http://$restServiceLocation/rest_zerbitzuak/vipusers/";

                curl_setopt($curl, CURLOPT_URL, $restServiceUrl);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                $str = curl_exec($curl);
                echo $str;

            }else{
                echo '<div class="errorBox"> Irakaslea izan behar zara baliabide hau atzitzeko </div>';
            }
        }else{
            echo '<div class="errorBox"> Irakasle kontu batean logeatuta egon behar zara baliabide hau atzitzeko </div>';
        }
    ?>

    </div>
    </section>
    <?php include '../html/Footer.html' ?>
</body>
</html>
