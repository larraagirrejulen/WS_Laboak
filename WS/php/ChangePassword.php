<?php

if(!(isset($_POST["posta"]) && isset($_POST["balioztatze_gakoa"]) && isset($_POST["pass"])){
  echo "0";
  exit();
}

include '../php/DbConfig.php';

$posta = $_POST["posta"];
$balioztatze_gakoa = $_POST["balioztatze_gakoa"];
$pasahitza = crypt($_POST["pass"], 'st');

try {
  $dsn = "mysql:host=$zerbitzaria;dbname=$db";
  $dbh = new PDO($dsn, $erabiltzailea, $gakoa);
} catch (PDOException $e){
  echo $e->getMessage();
}

// 1. Prepare
$stmt = $dbh->prepare("UPDATE users SET pasahitza=? WHERE posta=? AND gakoa=?");

// 2. Bind
$stmt->bindParam(1, $pasahitza);
$stmt->bindParam(2, $posta);
$stmt->bindParam(3, $balioztatze_gakoa);

// 3. Excecute
if($stmt->execute()){
  echo "1";
}else{
  echo "0";
}

//konexioa ixteko
$dbh = null;

?>
