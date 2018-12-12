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

$sql1="UPDATE rodada SET estado = '1' WHERE rodada.idrodada = '$idrodada'";
$res1 = mysqli_query($link, $sql1);
if ($res1) {
	header("Location: admin.php");
} else {
	header('Location: index.html');
	exit;
}


$sql2 = "SELECT idtimenome FROM timenome WHERE rodada_idrodada = '$idrodada'";
$res2 = mysqli_query($link, $sql2);
$idtimes=array();
if ($res2) {
	while ($row = mysqli_fetch_assoc($res2)) {
		$idtimes[] = $row["idtimenome"];
	}
} else {
	header('Location: index.html');
	exit;
}


$timessemponto=array();

$timesid=array();
$timesponto=array();
foreach($idtimes as $i => $value) {
	$sql3 = "SELECT pontos FROM partida_time WHERE timenome_idtimenome = '$idtimes[$i]' and rodada_idrodada = '$idrodada' and pontos IS NOT NULL";
	$res3 = mysqli_query($link, $sql3);
	$pontostime=array();

	if ($res3) {
		while ($row = mysqli_fetch_assoc($res3)) {
			$pontostime[] = $row["pontos"];
		}
	} else {
		header('Location: index.html');
		exit;
	}

	if (count($pontostime) ==0) {
		$timessemponto=$idtimes[$i];
	} else {
		$totalpontos=0;
		foreach($pontostime as $x => $value) {
			$totalpontos=$totalpontos+intval($pontostime[$x]);
		}
		$a= $idtimes[$i];
		$timesponto[$a] = $totalpontos;
		$timesid[$a] = $idtimes[$i];
	}

}

arsort($timesponto, SORT_NUMERIC);
$x=0;

foreach($timesponto as $r => $value) {

	$w = array_search($timesponto[$r], $timesponto);
	$x=$x+1;
	$sql4 = "UPDATE timenome SET posicao = '$x' WHERE timenome.idtimenome = $timesid[$w]";
	$res4 = mysqli_query($link, $sql4);
	if ($res4) {
	} else {
		header('Location: index.html');
		exit;
	}
}

###


#enviar email etc.
#palpite_posicao: definir estado


mysqli_close($link);

?>