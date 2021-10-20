<?php
unset($_COOKIE['ident']);
setcookie('ident', null, -1);

header("Location: index.php");
?>