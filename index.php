<?php
ob_start();
header("Content-type: text/html; charset=utf8");
header("Cache-Control: no cache");
include("conectar.php");

//setcookie("identumusu", "", time()-3600);
if(isset($_COOKIE["ident"])){
	$usu = $_COOKIE["ident"];	
}else{
	$usu = "";
}
ob_end_flush();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>

<meta charset="utf8">
<link rel="icon" href="lista.png">
<meta name="viewport" content="width=520">
<meta name="title" content="Lista de Compras">
<meta name="description" content="Lista de compras por itens individuais">
<meta name="keywords" content="lista de compras, lista de mercado">
<meta name="author" content="Octavio Oliveira">
<script type="text/javascript" src="js/jquery_min.js"></script>
<link href="meucss.css" rel="stylesheet">

<title>Lista de Compras</title>

</head>

<body>
<div id="conteudo">
<div id="central">
<center>

<!--Inicio Verifica Cookie usuario para acao na pagina!-->
<?php
if($usu == ""){
	echo "<form action='login.php' method='post' name='logar'>
	<input type='text' name='meuusu' class='formpadr' style='margin-top:15px;border:1px solid grey;width:250px;margin-right:20px;' 
	placeholder='Usuário...' required>
	<input type='submit' class='formpadr' id='cgenv' style='margin-top:15px;border:none;cursor:pointer;' name='enviando' value='Login'>
	</form><br>";
}else{
	echo "<div id='topo'>Bem-Vindo <b>".$usu."</b><a href='sair.php' style='margin-left:25px;
	color:#0070BC;font-size:17px;'><b>Sair</b></a></div><br>";
}
?>
<br><br>
<!--Fim Verifica Cookie usuario!-->

<!--Início inserção nova lista compras!-->
<div id="novalis">

<div id="mais">
<svg width="35" height="35" id="quadro" style="float:left;margin:15px 20px 0px 20px;fill:#005691;" viewBox="0 0 185 185"  xmlns="http://www.w3.org/2000/svg">
<rect y="76" width="185" height="32"/>
<rect x="76" y="185" width="185" height="32" transform="rotate(-90 76 185)"/>
</svg>
</div>

<b id="fundim" style="font-family:arial;color:#474747;font-size:17px;margin-left:45px;padding-top:25px;display:block;">Adicionar Lista de compras!</b>
<form action="inserir.php" method="post" name="criar">

<input type="text" class="formhide" name="crilista" style="border:none;width:290px;float:left;height:61px;margin-left:4px;" 
placeholder="Criar lista de compras..." required>
<input type="submit" class="formhide" id="cgenv" style="border:none;cursor:pointer;height:65px;width:75px;float:right;text-align:center;" name="envcriar" value="Salvar">

</form>
</div>
<br><br><br>

<script>
var contar = 0;
$('#mais').click(function() {
	
	if(contar == 0){
		$('#novalis').css({'background': 'white'});
		$('#quadro').css({'fill': 'white'});
		$('#mais').css({'background': '#005691'});
		$('#fundim').css({'display': 'none'});
		$('.formhide').css({'display': 'block'});
		contar ++;
	}else{
		$('#novalis').css({'background': '#eeeeee'});
		$('#quadro').css({'fill': '#005691'});
		$('#mais').css({'background': 'white'});
		$('#fundim').css({'display': 'block'});
		$('.formhide').css({'display': 'none'});
		contar = 0;
	}
});
</script>
<!--fim nova lista Compras!-->

<!--Inicio Listas de compras!-->
<?php
$f = 0;

if($usu == ""){
	$usufim = " ";
}else{$usufim = $usu;}


$busquinha = $pdo->prepare("SELECT * FROM listas WHERE usu = :usufim ORDER BY id DESC");
$busquinha->bindValue("usufim", $usufim);

$busquinha->execute();

$totalbox = $busquinha->rowCount();

if($totalbox != 0){while($row = $busquinha->fetch(PDO::FETCH_OBJ)){
	$idlista = $row->id;
	$datapre = $row->tempo;
	$lista = $row->lista;
	
	$data = date("d/m/Y", strtotime($datapre));
	
	$f++;
?>

<div id="listagem">
<a href="itens.php?id=<?php echo base64_encode($idlista); ?>" style="float:left;margin-bottom:10px;background:white;height:50px;width:410px;text-align:left;padding-left:6px;border:1px solid grey;
text-decoration:none;display:block;color:#474747;font-size:18px;font-type:arial;"><?php echo "<p style='margin-top:15px;'>".$data."  |  <b>".$lista."</b></p>"; ?></a>

<a class="exclui" href="exclista.php?id=<?php echo base64_encode($idlista); ?>">
<svg style="margin-top:3px;margin-left:1px;" width="34" height="34" viewBox="0 0 263 263" fill="white" xmlns="http://www.w3.org/2000/svg">
<rect x="54.4254" y="185.24" width="185" height="32" transform="rotate(-45 54.4254 185.24)"/>
<rect x="185.24" y="208.575" width="185" height="32" transform="rotate(-135 185.24 208.575)"/>
</svg>
</a>

</div>

<?php
}}
$pdo = null;
?>
<!--Fim Lista de compras!-->


</center>
<br><br>
</div>


</body>
</html>
