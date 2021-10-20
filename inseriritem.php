<?php
if(!empty($_POST["envcriar"])){
	include("conectar.php");
	
	$usupre = (@$_COOKIE["ident"]);
	
	if($usupre == ""){
	$usu = " ";}else{$usu = $usupre;}
	
	$idref = $_POST["myref"];
	$item = $_POST["meuitem"];
	$quant = $_POST["qt"];
	
	
	$poela = $pdo->prepare("INSERT INTO itens (idref, usu, item, qt, status) VALUES (:idref, :usu, :item, :quant, ' ')");
	$poela->bindValue("idref", $idref);
	$poela->bindValue("usu", $usu);
	$poela->bindValue("item", $item);
	$poela->bindValue("quant", $quant);

	$poela->execute();
	
	$pdo = null;
	
	$idvolta = base64_encode($idref);
	
	header("Location: itens.php?id=$idvolta");
}else{header("Location: index.php");}


?>