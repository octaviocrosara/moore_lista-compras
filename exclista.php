<?php
include("conectar.php");

if((@$_GET["id"]) != ""){
$usupre = (@$_COOKIE["ident"]);

if($usupre == ""){
	$usu = " ";
}else{$usu = $usupre;}

$idlist =  base64_decode($_GET["id"]);
	
$busquinha2 = $pdo->prepare("SELECT * FROM listas WHERE usu = :usufim AND id = :idlist ORDER BY id DESC LIMIT 1");
$busquinha2->bindValue("usufim", $usu);
$busquinha2->bindValue("idlist", $idlist);

$busquinha2->execute();

$totalbox2 = $busquinha2->rowCount();

if($totalbox2 != 0){
	$exclu = $pdo->prepare("DELETE FROM listas WHERE usu = :usufim AND id = :idlist ORDER BY id DESC LIMIT 1");
	$exclu->bindValue("usufim", $usu);
	$exclu->bindValue("idlist", $idlist);

	$exclu->execute();
}
}	
$pdo = null;

header("Location: index.php");
?>