<?php

$time1 = $_POST['time1']; 
$time2 = $_POST['time2'];


$link = mysqli_connect("127.0.0.1", "root", "", "cartola");
if (!$link) {
	header('Location: index.html');
	exit;
}

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

$sql0 = "SELECT * FROM timenome WHERE rodada_idrodada = '$idrodada'";

$res0 = mysqli_query($link, $sql0);

$time=array();
$y = 0;

if ($res0) {
	while ($row = mysqli_fetch_assoc($res0)) {
		$time[] = $row["timenome"];
	}

	foreach ($time as $i => $value) {
		if (($time[$i] == $time1) || ($time[$i] == $time2)) {
			$y = $y +1;
		}
	}

	if ($y == 2) {

		$sql2 = "INSERT INTO partida (rodada_idrodada) VALUES ('$idrodada')";
		$res2 = mysqli_query($link, $sql2);
		if ($res2) {
		} else {
			header('Location: index.html');
			exit;
		}

		$idpartida = 0;
		$sql3 = "SELECT MAX(idpartida) FROM partida WHERE rodada_idrodada = '$idrodada'";
		$res3 = mysqli_query($link, $sql3);
		if ($res3) {
			while ($row = mysqli_fetch_assoc($res3)) {
				$idpartida = $row["MAX(idpartida)"];
			}
		} else {
			header('Location: index.html');
			exit;
		}

		$sql4 = "INSERT INTO partida_time (partida_idpartida, timenome_idtimenome, rodada_idrodada) VALUES (('$idpartida'), (select (idtimenome) from timenome where timenome = '$time1'), ('$idrodada'))";
		$res4 = mysqli_query($link, $sql4);
		$sql5 = "INSERT INTO partida_time (partida_idpartida, timenome_idtimenome, rodada_idrodada) VALUES (('$idpartida'), (select (idtimenome) from timenome where timenome = '$time2'), ('$idrodada'))";
		$res5 = mysqli_query($link, $sql5);

		if ($res4 && $res5) {
			header('Location: definicaopartidas.php');
		} else {
			header('Location: index.html');
			exit;
		}

	} else {
		echo "ALGUM DOS TIMES INSERIDOS OU OS DOIS NÃO ESTÃO JOGANDO NESSA RODADA!";
		exit;
	}

} else {
	header('Location: index.html');
	exit;
}

$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

?>