<?php
    function erabUserCounterKendu($userPosta) {
        $doc = new DOMDocument; 
        $doc->load("../xml/UserCounter.xml");

        $thedocument = $doc->documentElement;
        
        // Erabiltzaile guztiak lotu
        $erablista = $thedocument->getElementsByTagName('erabiltzailea');
        
        // Borratu nahi den erabiltzailea erabiltzaile listan topatzen saiatu
        $nodeToRemove = null;
        foreach ($erablista as $erabiltzailea){
            // uneko erabiltzailearen posta erauzi 
            $attrValue = $erabiltzailea->getElementsByTagName('posta')[0]->nodeValue;
            // Uneko erabiltzaileak deslogeatu nahi den pertsonaren posta baduen frogatu
            if ($attrValue == $userPosta) {
                // Uneko erabiltzailea posta berdina du: borratu nahi den erabiltzailea topatu egin da.
                $nodeToRemove = $erabiltzailea;
            }
        }

        // Posta hori duen erabiltzaile kautoturik aurkitu bada:
        if($nodeToRemove != null){
            //Erabiltzaile hori duen nodoa borratu
            $thedocument->removeChild($nodeToRemove);
            // Logeatuta dauden pertsona kopuruaren kantitatea gutxitu
            $thedocument->setAttribute('logeatuta', ((int) $thedocument->getAttribute('logeatuta')) - 1);
            // DOM xml dokumentua gorde formatu egokiarekin
            $doc->preserveWhiteSpace = false;
            $doc->formatOutput = true;
            $doc->save("../xml/UserCounter.xml");
        }
        
    }
?>
