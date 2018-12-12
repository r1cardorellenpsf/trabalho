<?php

$nome = $_POST['nome'];
$email = $_POST['email'];
$login2 = $_POST['login2'];
$senha2 = $_POST['senha2'];

setcookie("nome", "");
setcookie("login", "");


$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

if (!$link) {
	header('Location: index.html');
    exit;
}

$sql = "INSERT INTO usuario (nome, login, email, senha) VALUES
		('$nome', '$login2', '$email', '$senha2')";

$res = mysqli_query($link, $sql);

if ($res) {
	setcookie("nome", $nome);
	setcookie("login", $login2);
	header('Location: selectrodada.php');
    exit;
} else {
    header('Location: index.html');
    exit;
}

mysqli_close($link);
?>

