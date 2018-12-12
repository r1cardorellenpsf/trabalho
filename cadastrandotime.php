<?php

$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

$timenovo = $_POST['time'];
$rodada = $_COOKIE['rodadaadm'];

$sql0 = "SELECT idrodada FROM rodada WHERE rodada = '$rodada'";
$res0 = mysqli_query($link, $sql0);

$idrodada ="";
if ($res0) {
	while ($row = mysqli_fetch_assoc($res0)) {
		$idrodada = $row["idrodada"];
	}
} else {
	header('Location: index.html');
	exit;
}

if ($idrodada=="") {
	echo "RODADA NAO EXISTENTE!";
} else {
	$sql1 = "SELECT * FROM timenome WHERE rodada_idrodada = '$idrodada'";
	$res1 = mysqli_query($link, $sql1);

	$x=0;
	$y=0;
	$time=array();

	if ($res1) {
		while ($row = mysqli_fetch_assoc($res1)) {
			$time[] = $row["timenome"];
			$x = $x+1;
		}

		foreach ($time as $i => $value) {
			if ($time[$i] == $timenovo) {
				$y = $y +1;
			} 
			echo $time[$i]."<br>";
		}

		if ($x < 20 && $y == 0) {
			$sql2 = "INSERT INTO timenome (timenome, rodada_idrodada) VALUES ('$timenovo', '$idrodada')";

			$res2 = mysqli_query($link, $sql2);

			if ($res2) {
				header('Location: cadastrotimes.php');
				exit;
			} else {
				header('Location: index.html');
				exit;
			}
		} else {
			echo "<br>JÁ TEM 20 TIMES CADASTRADOS OU HOUVE REPETIÇÃO DE TIMES!";
			exit;
		}
		exit;
	} else {
		header('Location: index.html');
		exit;
	}
}

mysqli_close($link);
?>
