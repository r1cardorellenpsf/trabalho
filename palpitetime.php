<?php

$link = mysqli_connect("127.0.0.1", "root", "", "cartola");


$cookieLogin = $_COOKIE['login'];
$cookieTime = $_COOKIE['time'];
$rodada = $_COOKIE['rodada'];

$posicao = $_POST['posicao'];
$posicao = intval($posicao);

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


$sql01 = "SELECT COUNT(*) from timenome WHERE rodada_idrodada = '$idrodada'";
$res01 = mysqli_query($link, $sql01);
$numtimes=0;
if ($res01) {
	while ($row = mysqli_fetch_assoc($res01)) {
		$numtimes = $row["COUNT(*)"];
	}
} else {
	header('Location: index.html');
	exit;
}

if ($posicao <= $numtimes) {
	$sql1 = "SELECT idusuario FROM usuario WHERE login = '$cookieLogin'";
	$res1 = mysqli_query($link, $sql1);
	$idusuario = "";

	if ($res1) {
		while ($row = mysqli_fetch_assoc($res1)) {
			$idusuario = $row["idusuario"];
		}

	} else {
		header('Location: index.html');
		exit;
	}



	$sql2 = "SELECT idpalpite_posicao FROM palpite_posicao WHERE timenome_idtimenome = '$cookieTime' and usuario_idusuario = '$idusuario' and rodada_idrodada = '$idrodada'";
	$res2 = mysqli_query($link, $sql2);
	$idpalpitepos = "";
	if ($res2) {
		while ($row = mysqli_fetch_assoc($res2)) {
			$idpalpitepos = $row["idpalpite_posicao"];
		}

	} else {
		header('Location: index.html');
		exit;
	}

	if ($idpalpitepos =="") {
	} else {
		$sql6 = "DELETE FROM palpite_posicao WHERE palpite_posicao.idpalpite_posicao = '$idpalpitepos' AND palpite_posicao.timenome_idtimenome = '$cookieTime' AND palpite_posicao.usuario_idusuario = '$idusuario'";
		$res6 = mysqli_query($link, $sql6);
		if ($res6) {
		} else {
			header("Location: index.html");
			exit;
		}
	}



	$sql4 = "SELECT timenome_idtimenome FROM palpite_posicao WHERE usuario_idusuario = '$idusuario' and palpite_posicao = '$posicao' and rodada_idrodada = '$idrodada'";
	$res4 = mysqli_query($link, $sql4);
	$idtimeant = "";
	if ($res4) {
		while ($row = mysqli_fetch_assoc($res4)) {
			$idtimeant = $row["timenome_idtimenome"];
		}

	} else {
		header('Location: index.html');
		exit;
	}

	if ($idtimeant=="") {
		$sql5 = "INSERT INTO palpite_posicao (usuario_idusuario, timenome_idtimenome, palpite_posicao, rodada_idrodada) VALUES (('$idusuario'), ('$cookieTime'), ('$posicao'), ('$idrodada'))";
	} else {
		$sql5 = "UPDATE palpite_posicao SET timenome_idtimenome = '$cookieTime' WHERE palpite_posicao.timenome_idtimenome = '$idtimeant' AND palpite_posicao.usuario_idusuario = '$idusuario'";
	}

	$res5 = mysqli_query($link, $sql5);

	if ($sql5) {
		header("Location: darpalpitetime.php");
	} else {
		header("??");
		exit;
	}

} else {
	echo "Escolha uma posicao de 1 a ".$numtimes.".";
}

mysqli_close($link);

?>