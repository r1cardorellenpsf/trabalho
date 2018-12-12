<?php

setcookie("nome", "");
setcookie("login", "");

$login1 = $_POST['login1'];
$senha1 = $_POST['senha1'];

$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

if (!$link) {
	header('Location: index.html');
	exit;
}

$sql = "SELECT nome FROM usuario WHERE login LIKE '$login1' AND senha LIKE '$senha1'";

$res = mysqli_query($link, $sql);

$nome = "";

if ($res) {
	while ($row = mysqli_fetch_assoc($res)) {
		$nome = $row["nome"];
		setcookie("nome", $nome);
		setcookie("login", $login1);
	}
	header('Location: selectrodada.php');
	exit;
} else {
	header('Location: index.html');
	exit;
}

mysqli_close($link);
?>

