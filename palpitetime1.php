<?php

$link = mysqli_connect("127.0.0.1", "root", "", "cartola");


$cookieLogin = $_COOKIE['login'];
$rodada = $_COOKIE['rodada'];

$time = $_POST['vencedorpalpite'];

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


$sql3 = "SELECT idtimenome FROM timenome WHERE timenome = '$time'";
$res3 = mysqli_query($link, $sql3);
$idtime = "";
if ($res3) {
	while ($row = mysqli_fetch_assoc($res3)) {
		$idtime = $row["idtimenome"];
	}

} else {
	header('Location: index.html');
	exit;
}

if ($idtime == "") {
	echo "O time inserido nao esta participando desta rodada!";

} else {
	$sql2 = "SELECT idpalpite_posicao FROM palpite_posicao WHERE timenome_idtimenome = '$idtime' and usuario_idusuario = '$idusuario' and rodada_idrodada = '$idrodada'";
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
		$sql6 = "DELETE FROM palpite_posicao WHERE palpite_posicao.idpalpite_posicao = '$idpalpitepos' AND palpite_posicao.timenome_idtimenome = '$idtime' AND palpite_posicao.usuario_idusuario = '$idusuario'";
		$res6 = mysqli_query($link, $sql6);
		if ($res6) {
		} else {
			Location("index.html");
			exit;
		}
	}

	$sql4 = "SELECT timenome_idtimenome FROM palpite_posicao WHERE usuario_idusuario = '$idusuario' and palpite_posicao = '1' and rodada_idrodada = '$idrodada'";
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
		$sql5 = "INSERT INTO palpite_posicao (usuario_idusuario, timenome_idtimenome, palpite_posicao, rodada_idrodada) VALUES (('$idusuario'), ('$idtime'), ('1'), ('$idrodada'))";
	} else {
		$sql5 = "UPDATE palpite_posicao SET timenome_idtimenome = '$idtime' WHERE palpite_posicao.timenome_idtimenome = '$idtimeant' AND palpite_posicao.usuario_idusuario = '$idusuario'";
	}

	$res5 = mysqli_query($link, $sql5);

	if ($sql5) {
		header("Location: feed.php");
	} else {
		header("??");
		exit;
	}

}

mysqli_close($link);

?>