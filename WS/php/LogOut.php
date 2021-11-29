<!DOCTYPE html>
<html>
<head>
    <?php include_once '../php/CaptureLoginInfo.php';
          include '../php/DecreaseGlobalCounter.php';

        if($logeatuta){
            erabUserCounterKendu($session_posta);
            session_destroy();
            
            echo("<h1 style='text-align:center;'> Agur! Laster Arte </h1>");
            echo('<script>
                alert("Milla esker zure bisitagatik. Laster arte '.$session_posta.'");
                window.location.href = "../php/Layout.php";
                </script>');
            
            
        }
    ?>

</head>
<body>
</body>
</html>
