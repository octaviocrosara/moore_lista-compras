<?php
$usuario = $_POST["meuusu"];

setcookie('ident', $usuario, time() + (3600*24*730));


header("Location: index.php");
?>
