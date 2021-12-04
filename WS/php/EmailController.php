<?php

if (!isset($_POST["posta"])) {
  exit();
}

include '../php/DbConfig.php';
$posta = $_POST["posta"];

try {
  $dsn = "mysql:host=$zerbitzaria;dbname=$db";
  $dbh = new PDO($dsn, $erabiltzailea, $gakoa);
} catch (PDOException $e){
  echo $e->getMessage();
}

// 1. Prepare
$stmt=$dbh->prepare("SELECT posta FROM users WHERE posta = ?");
// 2. Bind
$stmt->bindParam(1, $posta);
// 3. Excecute
$stmt->execute();
$result=$stmt->fetchAll(PDO::FETCH_OBJ);

if(count($result) == 1){
  echo '1';
}else{
  echo '0';
}

//konexioa ixteko
$dbh = null;

 ?>
