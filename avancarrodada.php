<?php

$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

$rodada = $_COOKIE['rodadaadm'];
$idrodada="";
$sql0 = "SELECT idrodada from rodada WHERE rodada = '$rodada'";
$res0 = mysqli_query($link, $sql0);
if ($res0) {
	while ($row = mysqli_fetch_assoc($res0)) {
		$idrodada = $row["idrodada"];
	}
} else {
	header('Location: index.html');
	exit;
}

$sql01 = "SELECT max(rodada) FROM rodada";
$res01 = mysqli_query($link, $sql01);
$maxrodada="";
if ($res01) {
	while ($row = mysqli_fetch_assoc($res01)) {
		$maxrodada = $row["max(rodada)"];
	}
} else {
	header('Location: index.html');
	exit;
}

if ($maxrodada == "Primeira") {
	$sql1 = "INSERT INTO rodada (rodada, estado) VALUES ('Segunda', '0')";
	setcookie("rodadaadm", "Segunda");

} else {
	if ($maxrodada == "Segunda") {
		$sql1 = "INSERT INTO rodada (rodada, estado) VALUES ('Terceira', '0')";
		setcookie("rodadaadm", "Terceira");
	} else {
		if ($maxrodada == "Terceira") {
			$sql1 = "INSERT INTO rodada (rodada, estado) VALUES ('Quarta', '0')";
			setcookie("rodadaadm", "Quarta");
		}
	}
}
$res1 = mysqli_query($link, $sql1);
if ($res1) {

	header('Location: admin.php');
} else {
	header('Location: index.html');
	exit;
}

?>