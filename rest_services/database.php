<?php
class Database {

    public static function Konektatu() {
        $link = mysqli_connect(_HOST_, _USERNAME_, _PASSWORD_, _DATABASE_);

        if (!$link) {
            throw new Exception("Errorea zerbitzarira konektatzean" . _HOST_ . ".");
        }

        return $link;
    }

    public static function Garbitu($link, $values) {
        if (gettype($values) == 'array') {
            $emaitza = array();
            foreach ($values as $val) {  
                if (function_exists("mysqli_real_escape_string")) {
                    $val = mysqli_real_escape_string($link, $val);
                } else {
                    $val = addslashes($val);
                }
                $emaitza [] = $val;
            }
            return $emaitza;
        } else {
            
            if (function_exists("mysqli_real_escape_string")) {
                $values = mysqli_real_escape_string($link, $values);
            } else {
                $values = addslashes($values);
            }
            return $values;
        }
    }

    public static function GauzatuKontsulta($link = null, $sql = "") {
        if ($sql == "") {
            throw new Exception("Ez da kontsultarik ezarri exekutatzeko.");
        }

        if (!$link) {
            throw new Exception("Ez da konexiorik ezarri.");
        }

        $emaitza = mysqli_query($link,$sql);
        if (!$emaitza) {
            throw new Exception(mysqli_error($link));
        }

        $datuak = "";
        //if (gettype($emaitza) == "resource") {
         while ($row = mysqli_fetch_array($emaitza)) {
                $datuak = $datuak . " ". $row[0]."<br>";
            }
            mysqli_free_result($emaitza);
            return $datuak;
        // } else {
            // return 0;
    }

    public static function GauzatuEskalatu($link = null, $sql = "") {
        if ($sql == "") {
            throw new Exception("Ez da kontsultarik ezarri exekutatzeko.");
        }

        if (!$link) {
            throw new Exception("Errorea zerbitzarira konektatzean.");
        }

        $emaitza = mysqli_query($link, $sql);
        if (!$emaitza) {
            throw new Exception(mysqli_error($link));
        }
        $datua = null;
        if ($row = mysqli_fetch_row($emaitza)) {
            $datua = $row [0];
        }
        mysqli_free_result($emaitza);
        return $datua;
    }

    public static function GauzatuEzKontsulta($link = null, $sql = "") {
        if ($sql == "") {
            throw new Exception("Ez da kontsultarik ezarri exekutatzeko.");
        }

        if (!$link) {
            throw new Exception("Errorea zerbitzarira konektatzean.");
        }
		mysqli_query($link,$sql);
		if (mysqli_affected_rows($link)==1)
		{return 1;}
		else
        {return 0;};
    }

    public static function Deskonektatu($link) {
        mysqli_close($link);
    }

    public static function LastInsertId($link) {
        $sql = "SELECT LAST_INSERT_ID();";
        if (!$link) {
            throw new Exception("Errorea zerbitzarira konektatzean.");
        }

        $emaitza = mysqli_query($link, $sql);
        if (!$emaitza) {
            throw new Exception(mysqli_error($link));
        }
        $datua = null;
        if ($row = mysqli_fetch_row($emaitza)) {
            $datua = $row [0];
        }
        mysqli_free_result($emaitza);
        return $datua;
    }

}
