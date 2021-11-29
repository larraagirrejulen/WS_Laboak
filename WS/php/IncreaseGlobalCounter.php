<?php
    function erabUserCounterGehitu($userPosta) {
        if (!frogatuUserLogeatuta($userPosta)) {
            $xml = simplexml_load_file("../xml/UserCounter.xml");

            $erab = $xml -> addChild('erabiltzailea');
            $erab -> addChild('posta', $userPosta);

            $xml->attributes()->logeatuta = ((int) $xml->attributes()->logeatuta) + 1;

            $domxml = new DOMDocument('1.0');
            $domxml->preserveWhiteSpace = false;
            $domxml->formatOutput = true;
            /* @var $xml SimpleXMLElement */
            $domxml->loadXML($xml->asXML());
            $domxml->save("../xml/UserCounter.xml");
        }
    }
?>

<?php
    function frogatuUserLogeatuta($posta){
        $xml = simplexml_load_file("../xml/UserCounter.xml");

        foreach($xml->Children() as $erabiltzailea){
            if($erabiltzailea->posta == $posta){
                return true;
            }
        }
        return false;
    }
?>