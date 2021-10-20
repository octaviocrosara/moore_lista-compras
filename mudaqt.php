<?php
	//Incluir a conexão com banco de dados
	include('conectar.php');
	$classe = (@$_POST['wordqt']);
	
	//Recuperar o valor da palavra
	$campos = explode(";", $classe);
	$classe2 = $campos[0]; 
	$classe1 = $campos[1];
	
	//Pesquisar no banco de dados nome do curso referente a palavra digitada pelo usuário
	$cursos1 = $pdo->prepare("UPDATE itens SET qt = :classe2 WHERE id = :classe1 ORDER BY id DESC LIMIT 1");
	$cursos1->bindValue("classe2", $classe2);
	$cursos1->bindValue("classe1", $classe1);
	$cursos1->execute();

	$pdo = null;
?>