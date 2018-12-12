<?php


$login = $_POST['loginadm'];
$senha = $_POST['senhaadm'];

$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

if (!$link) {
	header('Location: index.html');
	exit;
}

$sql = "SELECT * FROM admin";

$res = mysqli_query($link, $sql);

$nome = "";

if ($res) {
	while ($row = mysqli_fetch_assoc($res)) {
		$loginadm = $row["login"];
		$senhaadm = $row["senha"];
	}
	if ($login == $loginadm && $senha == $senhaadm) {
		header('Location: rodadaadmin.php');
	} else {
		header('Location: loginadmin.php');
	}
	
	exit;
} else {
	header('Location: index.html');
	exit;
}

mysqli_close($link);
?>

