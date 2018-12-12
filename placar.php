<?php

$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

function transformando($xx) {
	if ($xx<0) {
		return -($xx);
	} else {
		return $xx;
	}
}

$cookiePartida = $_COOKIE['partida'];

$times=array();

$cookieTime1 = $_COOKIE['time1'];
$times[]=$cookieTime1;
$cookieTime2 = $_COOKIE['time2'];
$times[]=$cookieTime2;

$gols=array();
$gols1 = $_POST['gols1'];
$gols[]=$gols1;
$gols2 = $_POST['gols2'];
$gols[]=$gols2;

$sql1= "UPDATE partida_time SET gols = '$gols1' WHERE partida_time.partida_idpartida = '$cookiePartida' AND partida_time.timenome_idtimenome = '$cookieTime1'";
$res1 = mysqli_query($link, $sql1);

$sql2 = "UPDATE partida_time SET gols = '$gols2' WHERE partida_time.partida_idpartida = '$cookiePartida' AND partida_time.timenome_idtimenome = '$cookieTime2'";
$res2 = mysqli_query($link, $sql2);

if ($gols1>$gols2) {
	$sql01= "UPDATE partida_time SET pontos = '3' WHERE partida_time.partida_idpartida = '$cookiePartida' AND partida_time.timenome_idtimenome = '$cookieTime1'";
	$sql02= "UPDATE partida_time SET pontos = '0' WHERE partida_time.partida_idpartida = '$cookiePartida' AND partida_time.timenome_idtimenome = '$cookieTime2'";
} else {
	if ($gols2>$gols1) {
		$sql01= "UPDATE partida_time SET pontos = '0' WHERE partida_time.partida_idpartida = '$cookiePartida' AND partida_time.timenome_idtimenome = '$cookieTime1'";
		$sql02= "UPDATE partida_time SET pontos = '3' WHERE partida_time.partida_idpartida = '$cookiePartida' AND partida_time.timenome_idtimenome = '$cookieTime2'";
	} else {
		$sql01= "UPDATE partida_time SET pontos = '1' WHERE partida_time.partida_idpartida = '$cookiePartida' AND partida_time.timenome_idtimenome = '$cookieTime1'";
		$sql02= "UPDATE partida_time SET pontos = '1' WHERE partida_time.partida_idpartida = '$cookiePartida' AND partida_time.timenome_idtimenome = '$cookieTime2'";
	}
}
$res01 = mysqli_query($link, $sql01);
$res02 = mysqli_query($link, $sql02);

if ($res1 && $res2 && $res01 && $res02) {
} else {
	echo "Location: index.html";
	exit;
}

foreach($times as $i => $value) {
	$palpites=array();
	$idpalpites=array();
	$sql3 = "SELECT palpite FROM palpite WHERE partida_time_partida_idpartida = '$cookiePartida' and partida_time_time_idtime = '$times[$i]'";
	$res3 = mysqli_query($link, $sql3);
	$sql35 = "SELECT idpalpite FROM palpite WHERE partida_time_partida_idpartida = '$cookiePartida' and partida_time_time_idtime = '$times[$i]'";
	$res35 = mysqli_query($link, $sql35);
	if ($res3 && $res35) {
		while ($row = mysqli_fetch_assoc($res3)) {
			$palpites[] = $row["palpite"];
		}
		while ($row = mysqli_fetch_assoc($res35)) {
			$idpalpites[] = $row["idpalpite"];
		}
	} else {
		header("Location: index.html");
		exit;
	}

	if (count($palpites)==0) {
		header('Location: definicaoplacar.php');
	} else {
		foreach($palpites as $x => $value) {
			if ($palpites[$x] == $gols[$i]) {
				$sql4 = "UPDATE palpite SET palpiteponto = '1', palpitepontorel = '0' WHERE palpite.idpalpite = '$idpalpites[$x]' AND palpite.partida_time_partida_idpartida = '$cookiePartida' AND palpite.partida_time_time_idtime = '$times[$i]'";
				$res4 = mysqli_query($link, $sql4);
			} else {
				$sql5 = "UPDATE palpite SET palpiteponto = '0', palpitepontorel = '".transformando($palpites[$x]-$gols[$i])."' WHERE palpite.idpalpite = '$idpalpites[$x]' AND palpite.partida_time_partida_idpartida = '$cookiePartida' AND palpite.partida_time_time_idtime = '$times[$i]'";
				$res5 = mysqli_query($link, $sql5);
			}

			if ($res4 || $res5) {
			} else {
				header("Location: index.html");
				exit;
			}
		}
	}
}

header("Location: definicaoplacar.php");

mysqli_close($link);

#echo "$cookiePartida<br>";
#echo "$cookieTime1 ";
#echo "$gols1<br>";
#echo "$cookieTime2 ";
#echo "$gols2<br>"

?>