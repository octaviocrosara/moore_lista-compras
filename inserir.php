<?php
if(!empty($_POST["envcriar"])){
	include("conectar.php");
	
	$usupre = (@$_COOKIE["ident"]);
	
	if($usupre == ""){
	$usu = " ";}else{$usu = $usupre;}
	
	$nomelista = $_POST["crilista"];
	
	$poela = $pdo->prepare("INSERT INTO listas (usu, lista) VALUES (:usu, :nomelista)");
	$poela->bindValue("usu", $usu);
	$poela->bindValue("nomelista", $nomelista);

	$poela->execute();
	
	$pdo = null;
}

header("Location: index.php");
?>