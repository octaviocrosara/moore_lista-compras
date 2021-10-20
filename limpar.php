<?php
if((@$_GET["id"]) != ""){
include("conectar.php");
$usupre = (@$_COOKIE["ident"]);

if($usupre == ""){
	$usu = " ";
}else{$usu = $usupre;}

$idlist =  base64_decode($_GET["id"]);
$idit =  base64_decode($_GET["idit"]);
	
$busquinha2 = $pdo->prepare("SELECT * FROM listas WHERE usu = :usufim AND id = :idlist ORDER BY id DESC LIMIT 1");
$busquinha2->bindValue("usufim", $usu);
$busquinha2->bindValue("idlist", $idlist);

$busquinha2->execute();

$totalbox2 = $busquinha2->rowCount();

if($totalbox2 != 0){
	$exclu = $pdo->prepare("DELETE FROM itens WHERE usu = :usufim AND idref = :idlist ORDER BY id DESC");
	$exclu->bindValue("usufim", $usu);
	$exclu->bindValue("idlist", $idlist);

	$exclu->execute();
	
	$idvolta = base64_encode($idlist);
	
	header("Location: itens.php?id=$idvolta");
}
$pdo = null;
}else{header("Location: index.php");}
?>