<?php
	//Incluir a conexão com banco de dados
	include('conectar.php');
	
	//Recuperar o valor da palavra
	$classe1 = trim(@$_POST['word']);
	
	//Pesquisar no banco de dados nome do curso referente a palavra digitada pelo usuário
	$cursos1 = $pdo->prepare("UPDATE itens SET status = ' ' WHERE id = :classe1 ORDER BY id DESC LIMIT 1");
	$cursos1->bindValue("classe1", $classe1);
	$cursos1->execute();

	$pdo = null;
?>