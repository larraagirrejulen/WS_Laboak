<html>
    <head>
        <?php include '../html/Head.html'?>
        <link rel="stylesheet" type="text/css" href="../styles/BoxTypes.css">
        <link rel="stylesheet" type="text/css" href="../styles/Tables.css">
    </head>
    <body>
        <?php include '../php/Menus.php' ?>
        <section class="main" id="s1">
            <div class="tableContainer" id="jsontable">
                <table class="table" >
                    <caption>JSON GALDERAK</caption>
                    <thead>
                        <tr>
                            <th>Egilea</th>
                            <th>Enuntziatua</th>
                            <th>Erantzun Zuzena</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($logeatuta){
                            $data = file_get_contents('../json/Questions.json');
                            $json = json_decode($data);
                            foreach ($json-> assessmentItems as $assessmentItem){
                                $egilea = $assessmentItem->author;

                                $enuntziatua  = $assessmentItem->itemBody->p;
                                
                                $erantzunZuzena = $assessmentItem->correctResponse->response;
                                    
                                echo '<tr>';
                                echo "
                                    <td>$egilea</td>
                                    <td>$enuntziatua</td>
                                    <td>$erantzunZuzena</td>
                                ";
                                echo '</tr>';   
                            }
                        }else{
                            echo("<div class='errorBox'><p>Ezin duzu funtzionalitate hau atzitu logeatuta ez bazaude.</p><p> Logeatu eta saiatu berriro.</p></div> ");
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
  
        <?php include '../html/Footer.html' ?>
    </body>
</html>