<?php
ob_start();
header("Content-type: text/html; charset=utf-8");
header("Cache-Control: no cache");
include("conectar.php");

//setcookie("identumusu", "", time()-3600);
if(isset($_COOKIE["ident"])){
	$usu = $_COOKIE["ident"];	
}else{
	$usu = "";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>

<meta charset="iso-8859-1">
<link rel="icon" href="lista.png">
<meta name="viewport" content="width=520">
<meta name="title" content="Itens Lista">
<meta name="description" content="Itens Lista de compras">
<meta name="keywords" content="lista de compras, lista de mercado">
<meta name="author" content="Octavio Oliveira">
<script type="text/javascript" src="js/jquery_min.js"></script>
<link href="meucss.css" rel="stylesheet">

<title>Itens Lista</title>

</head>

<body>
<div id="conteudo2">
<div id="central">
<center>

<!--Inicio Verifica Cookie usuario para acao na pagina!-->
<?php
	echo "<div id='topo'>Bem-Vindo <b>".$usu."</b><a href='index.php' style='margin-left:25px;
	color:#0070BC;font-size:17px;'><b>Voltar</b></a></div>";
?>
</center>
<br><br>
<!--Fim Verifica Cookie usuario!-->

<!--Inserindo itens na lista!-->
<div id="novalis2">

<form action="inseriritem.php" method="post" name="criar">

<?php
$idlist =  base64_decode($_GET["id"]);
?>

<input type="text" name="myref" style="display:none;" value="<?php echo $idlist;?>" readonly="true">

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<select height="60" type="text" id="js-example-basic-multiple" name="meuitem" style="display:block;font-size:14px;border:none;width:260px;float:left;height:61px;" 
 multiple="multiple" required>

<?php
$con_tipos1 = $pdo->prepare("SELECT produto FROM produtf ORDER BY produto ASC");
$con_tipos1->execute(); 
?>

<?php while ($dado1 = $con_tipos1->fetch(PDO::FETCH_OBJ)){ ?>
<option value="<?php echo $dado1->produto; ?>"><?php echo $dado1->produto; ?></option>
<?php } ?>
  
</select>

<script>
$(document).ready(function() {
    $('#js-example-basic-multiple').select2({
	placeholder: 'Inserir Item...',
	dropdownCssClass: "bigdrop",
    tags: true,
	maximumSelectionLength: 1
	
	})
});
</script>


<table style="background:white;float:right;height:60px;display:block;">
<tr>
<td style="border:1px solid grey;width:27px;">
	<div class="menos"><center><br><b>-</b></center></div>
</td>
<td style="border:1px solid grey;width:27px;">
<input type="text" id="quantos" name="qt" style="font-size:25px;border:none;width:40px;border-radius:4px;border-color:#eeeee;padding-left:6px;" 
placeholder="1" value="1" readonly="true"></td>
	<td style="border:1px solid grey;width:27px;"><div class="mais"><center><br><b>+</b></center></div></td>

<style>
.menos{cursor:pointer;height:55px;font-size:18px;}
.mais{cursor:pointer;height:55px;font-size:18px;}
.select2-container{height: 60px;}
.select2-selection{height: 60px;}
</style>
<script>
var acomp2 = 1;
$('.menos').click(function(){
	if(acomp2 > 1){
		acomp2--;
		$('#quantos').val(acomp2);
	}
	
	console.log(acomp2);
});

$('.mais').click(function(){
	acomp2++;

	$('#quantos').val(acomp2);
	
	console.log(acomp2);
});
</script>
<td style="background:#FFF8DC;">
<input type="submit" class="formitem" id="cgenv" style="margin-left:7px;border:none;cursor:pointer;height:58px;width:75px;float:right;" name="envcriar" 
value="Salvar">
</td>
</tr>
</table>

</form>
</div>
<!--Fim Inserindo itens na lista!-->
<br><br>
<center>
<!--Verificando se usuario eh dono da lista!-->
<?php
if($idlist != ""){
$usupre = (@$_COOKIE["ident"]);

if($usupre == ""){
	$usu = " ";
}else{$usu = $usupre;}

$f = 0;

$busquinha2 = $pdo->prepare("SELECT * FROM listas WHERE usu = :usufim AND id = :idlist ORDER BY id DESC LIMIT 1");
$busquinha2->bindValue("usufim", $usu);
$busquinha2->bindValue("idlist", $idlist);

$busquinha2->execute();

$totalbox2 = $busquinha2->rowCount();

if($totalbox2 != 0){while($row = $busquinha2->fetch(PDO::FETCH_OBJ)){
	$idlista = $row->id;
	$datapre = $row->tempo;
	$lista = $row->lista;
		
	echo "<center><b style='font-family:arial;font-size:16px;'>".$lista."</b></center><br>";

	$busquinha = $pdo->prepare("SELECT * FROM itens WHERE idref = :idlista ORDER BY id DESC");
	$busquinha->bindValue("idlista", $idlista);

	$busquinha->execute();

	$totalbox = $busquinha->rowCount();

	if($totalbox != 0){while($row2 = $busquinha->fetch(PDO::FETCH_OBJ)){
		$iditem = $row2->id;
		$dataitem = $row2->tempo;
		$oitem = $row2->item;
		$quantidade = $row2->qt;
		$status = $row2->status;
	
		$data = date("d/m/Y", strtotime($datapre));
	
	$f++;
	
	if($status == "X"){
		$vaimos2 = "block"; $vaimos1 = "none";}else{$vaimos1 = "block"; $vaimos2 = "none"; }
?>
<!--Fim Verificando Usuario!-->

<div id="listagem<?php echo $f; ?>" style="height:45px;width:480px;display:<?php echo $vaimos1; ?>;">

<div id="linha<?php echo $f; ?>">
<?php echo "<p style='margin-top:5px;'><b>".$oitem."</b></p>"; ?>
</div>

<table style="background:white;float:left;height:25px;display:block;margin-left:3px;margin-top:3px;">
<tr>
<td style="border:1px solid grey;width:15px;">
	<div class="menos<?php echo $f; ?>"><center><b>-</b></center></div>
</td>
<td style="border:1px solid grey;width:20px;">
<input type="text" id="quantos<?php echo $f; ?>" name="qt" style="font-size:13px;border:none;width:20px;border-radius:4px;border-color:#eeeee;padding-left:6px;" 
value="<?php echo $quantidade; ?>" readonly="true"></td>
	<td style="border:1px solid grey;width:15px;"><div class="mais<?php echo $f; ?>"><center><b>+</b></center></div></td>
</tr>
</table>
<style>
.menos<?php echo $f; ?>{cursor:pointer;height:21px;font-size:14px;}
.mais<?php echo $f; ?>{cursor:pointer;height:21px;font-size:14px;}
</style>
<script>
var acompqt<?php echo $f; ?> = $('#quantos<?php echo $f; ?>').val();
$('.menos<?php echo $f; ?>').click(function(){
	if(acompqt<?php echo $f; ?> > 1){
		acompqt<?php echo $f; ?>--;
		$('#quantos<?php echo $f; ?>').val(acompqt<?php echo $f; ?>);
	}

	var dadospreqt;
	var informeqt = <?php echo $iditem; ?>;
	
	//Pesquisar os cursos sem refresh na página
	
		var presquisaqt = $('#quantos<?php echo $f; ?>').val();
		
		//Verificar se há algo digitado

			var dadospreqt = {
				wordqt : presquisaqt + ";" + informeqt
			}

			$.post('mudaqt.php', dadospreqt, function(value){
				//Mostra dentro da ul os resultado obtidos 
			});

});

$('.mais<?php echo $f; ?>').click(function(){
	acompqt<?php echo $f; ?>++;

	$('#quantos<?php echo $f; ?>').val(acompqt<?php echo $f; ?>);
	
		var dadospreqt;
		var informeqt = <?php echo $iditem; ?>;
	
	//Pesquisar os cursos sem refresh na página
	
		var presquisaqt = $('#quantos<?php echo $f; ?>').val();
		
		//Verificar se há algo digitado

			var dadospreqt = {
				wordqt : presquisaqt + ";" + informeqt
			}

			$.post('mudaqt.php', dadospreqt, function(value){
				//Mostra dentro da ul os resultado obtidos 
			});
});
</script>



<style>
#linha<?php echo $f; ?>{float:left;margin-bottom:5px;background:white;height:35px;width:350px;text-align:left;padding-left:6px;border:1px solid grey;
text-decoration:none;display:block;color:#474747;font-size:17px;font-type:arial;cursor:pointer;}
</style>

<a class="exclui2" href="excitem.php?id=<?php echo base64_encode($idlista); ?>&idit=<?php echo base64_encode($iditem); ?>">
<svg style="margin-top:3px;margin-left:1px;" width="22" height="22" viewBox="0 0 263 263" fill="white" xmlns="http://www.w3.org/2000/svg">
<rect x="54.4254" y="185.24" width="185" height="32" transform="rotate(-45 54.4254 185.24)"/>
<rect x="185.24" y="208.575" width="185" height="32" transform="rotate(-135 185.24 208.575)"/>
</svg>
</a>

</div>

<div id="listasai<?php echo $f; ?>" style="height:45px;width:480px;display:<?php echo $vaimos2; ?>;">

<div id="linhasai<?php echo $f; ?>">
<?php echo "<p style='margin-top:5px;'><b>".$oitem."  |  Qt: ".
$quantidade." x</b></p>"; ?>
</div>

<style>
#linhasai<?php echo $f; ?>{float:left;margin-bottom:5px;background:#eeeeee;height:35px;width:420px;text-align:left;padding-left:6px;border:1px solid grey;
text-decoration:none;display:block;color:#474747;font-size:17px;font-type:arial;cursor:pointer;text-decoration: line-through;}
</style>

</div>

<script>
$('#linha<?php echo $f; ?>').click(function() {
	$('#listasai<?php echo $f; ?>').css({'display': 'block'});
	$('#listagem<?php echo $f; ?>').css({'display': 'none'});
	
	var dadospre;
	var informe = <?php echo $iditem; ?>;
	
	//Pesquisar os cursos sem refresh na página
	
		var presquisa = informe;
		
		//Verificar se há algo digitado

			var dadospre = {
				word : presquisa
			}

			$.post('mudastatus.php', dadospre, function(value){
				//Mostra dentro da ul os resultado obtidos 
			});

});

$('#listasai<?php echo $f; ?>').click(function() {
	$('#listasai<?php echo $f; ?>').css({'display': 'none'});
	$('#listagem<?php echo $f; ?>').css({'display': 'block'});
	
	var dadospre;
	var informe = <?php echo $iditem; ?>;
	
	//Pesquisar os cursos sem refresh na página
	
		var presquisa = informe;
		
		//Verificar se há algo digitado

			var dadospre = {
				word : presquisa
			}

			$.post('voltastatus.php', dadospre, function(value){
				//Mostra dentro da ul os resultado obtidos 
			});
});
</script>
<?php
	}}
}
$pdo = null;
}else{header("Location: index.php");}
}else{header("Location: index.php");}
ob_end_flush();
?>
<br><br>

<?php
$saiidlis = base64_encode($idlista);
$saiidit = base64_encode($iditem);

if($f > 0){echo "<center><a href='limpar.php?id=$saiidlis&idit=$saiidit' style='margin-left:25px;color:#0070BC;font-size:17px;'>
<b>Limpar Lista</b></a></center>";}
?>
<br><br>
</div>

</body>
</html>
