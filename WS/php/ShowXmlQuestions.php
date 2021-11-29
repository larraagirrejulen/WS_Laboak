<html>
    <head>
        <?php include '../html/Head.html'?>
        <link rel="stylesheet" type="text/css" href="../styles/BoxTypes.css">
        <link rel="stylesheet" type="text/css" href="../styles/Tables.css">
    </head>
    <body>
        <?php include '../php/Menus.php' ?>
        <section class="main" id="s1">
            <div class="tableContainer">
                <table class="table">
                    <caption>XML GALDERAK</caption>
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
                            $xml = simplexml_load_file('../xml/Questions.xml');
                            foreach ($xml-> children() as $assessmentItem){
                                $egilea = $assessmentItem["author"];

                                $enuntziatua  = $assessmentItem[0]->itemBody[0]->p[0];
                                
                                $erantzunZuzena = $assessmentItem[0]->correctResponse[0]->response[0];
                                    
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