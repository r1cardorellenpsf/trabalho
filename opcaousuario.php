<?php

$opcao = $_POST['opcao'];

if ($opcao == "darpalpite") {
	header('Location: darpalpite.php');
}
if ($opcao == "darpalpitetime") {
	header('Location: darpalpitetime.php');
}
if ($opcao == "classificacaop") {
	header('Location: classificacaop.php');
}
if ($opcao == "classificacaot") {
	header('Location: classificacaot.php');
}
if ($opcao == "ponto") {
	header('Location: ponto.php');
}
if ($opcao == "verpalpite") {
	header('Location: vendopalpite.php');
}
if ($opcao == "classificacaogeral") {
	header('Location: classificacaogeral.php');
}

?>