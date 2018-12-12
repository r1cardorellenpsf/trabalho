<?php

$opcao = $_POST['opcao'];

if ($opcao == "time") {
	header('Location: vertimes.php');
}
if ($opcao == "cadastro") {
	header('Location: cadastrotimes.php');
}
if ($opcao == "programadas") {
	header('Location: verpartidas.php');
}
if ($opcao == "partida") {
	header('Location: definicaopartidas.php');
}
if ($opcao == "placar") {
	header('Location: definicaoplacar.php');

}
if ($opcao == "avancar") {
	header("Location: avancarrodada.php");
}
if ($opcao == "parar") {
	header("Location: pararacaorodada.php");

}
if ($opcao == "devolver") {
	header("Location: devolveracaorodada.php");

}
?>