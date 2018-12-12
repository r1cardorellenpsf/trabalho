<?php

$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

$cookiePartidaPalpite = $_COOKIE['palpite'];
$cookieLogin = $_COOKIE['login'];
$cookieTime1 = $_COOKIE['time1'];
$cookieTime2 = $_COOKIE['time2'];
$rodada = $_COOKIE['rodada'];

$gols1 = $_POST['gols1'];
$gols2 = $_POST['gols2'];

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
###
$sql01 = "SELECT idpalpite FROM palpite WHERE usuario_idusuario = '$idusuario' and partida_time_partida_idpartida = '$cookiePartidaPalpite' and rodada_idrodada = '$idrodada'";
$res01 = mysqli_query($link, $sql01);
$idpalpiteant[] = array();
if ($res01) {
	while ($row = mysqli_fetch_assoc($res01)) {
		$idpalpiteant[] = $row["idpalpite"];
	}

} else {
	header('Location: index.html');
	exit;
}

if (count($idpalpiteant)==0) {
} else {
	foreach($idpalpiteant as $t => $value) {

		$sql02 = "DELETE FROM palpite WHERE palpite.idpalpite = '$idpalpiteant[$t]' AND palpite.partida_time_partida_idpartida = '$cookiePartidaPalpite' AND palpite.rodada_idrodada = '$idrodada' and palpite.usuario_idusuario = '$idusuario'";
		$res02 = mysqli_query($link, $sql02);
		if ($res02) {
		} else {
			echo "??";
			#header("Location: index.html");
			exit;
		}

	}
}
###

$sql2 = "INSERT INTO palpite (usuario_idusuario, partida_time_partida_idpartida, partida_time_time_idtime, palpite, rodada_idrodada) VALUES (('$idusuario'), ('$cookiePartidaPalpite'), ('$cookieTime1'), ('$gols1'), ('$idrodada'))";
$res2 = mysqli_query($link, $sql2);

$sql3 = "INSERT INTO palpite (usuario_idusuario, partida_time_partida_idpartida, partida_time_time_idtime, palpite, rodada_idrodada) VALUES (('$idusuario'), ('$cookiePartidaPalpite'), ('$cookieTime2'), ('$gols2'), ('$idrodada'))";
$res3 = mysqli_query($link, $sql3);

if ($sql2 && $sql3) {
	header("Location: darpalpite.php");
} else {
	header("Location: index.php");
	exit;
}

mysqli_close($link);


?>