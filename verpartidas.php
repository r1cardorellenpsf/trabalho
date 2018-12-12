<?php

$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

echo "<style type=text/css>
body{
	background-color: #7CFC00;
}
</style>";

function exibir_partidas_definidas($partida) {

	$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

	foreach ($partida as $i => $value) {

		$idtimes=array();
		$sql2 = "SELECT timenome_idtimenome FROM partida_time WHERE partida_idpartida = $partida[$i]";
		$res2 = mysqli_query($link, $sql2);

		if ($res2) {
			while ($row = mysqli_fetch_assoc($res2)) {
				$idtimes[] = $row["timenome_idtimenome"];
			}

		} else {
			echo $idtimes;
			exit;
		}

		$times = array();
		$gols = array();

		foreach ($idtimes as $y => $value) {

			$sql3 = "SELECT timenome FROM timenome WHERE idtimenome = $idtimes[$y]";
			$res3 = mysqli_query($link, $sql3);

			$sql5 = "SELECT gols FROM partida_time WHERE partida_idpartida = '$partida[$i]' and timenome_idtimenome = $idtimes[$y]";
			$res5 = mysqli_query($link, $sql5);

			if ($res3 && $res5) {
				while ($row = mysqli_fetch_assoc($res3)) {
					$times[] = $row["timenome"];
				}
				while ($row = mysqli_fetch_assoc($res5)) {
					$gols[] = $row["gols"];
				}

			} else {
				echo $times;
				exit;

			}

		}

		foreach ($times as $x => $value) {

			if ($x==0) {
				echo $times[$x];
				echo " ".$gols[$x]." x ";
			} else {
				echo " ".$gols[$x]." ";
				echo $times[$x]."<br>";

			}
		}
		echo "<br>";
	}

	#echo "<br>";

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

echo "<br><h2>".$rodada." rodada</h2>";
echo "<h3>Partidas programadas</h3>";


$sql1 = "SELECT partida_idpartida FROM partida_time WHERE rodada_idrodada = '$idrodada' and gols IS NULL GROUP BY partida_idpartida HAVING Count(*) > 1";
$res1 = mysqli_query($link, $sql1);
$idpartida=array();

if ($res1) {

	while ($row = mysqli_fetch_assoc($res1)) {
		$idpartida[] = $row["partida_idpartida"];
	}

} else {
	header('Location: index.html');
	exit;
}

if (count($idpartida)==0) {
	echo "Nenhuma partida foi programada até o momento!";
} else {

	for ($i=0; $i<count($idpartida); $i++) {
		$idtimes=array();
		$sql2 = "SELECT timenome_idtimenome FROM partida_time WHERE partida_idpartida = $idpartida[$i]";
		$res2 = mysqli_query($link, $sql2);

		if ($res2) {
			while ($row = mysqli_fetch_assoc($res2)) {
				$idtimes[] = $row["timenome_idtimenome"];
			}

		} else {
			header('Location: index.html');
			exit;
		}
		$times = array();
		foreach ($idtimes as $y => $value) {
			$sql3 = "SELECT timenome FROM timenome WHERE idtimenome = $idtimes[$y]";
			$res3 = mysqli_query($link, $sql3);

			if ($res3) {
				while ($row = mysqli_fetch_assoc($res3)) {
					$times[] = $row["timenome"];
				}

			} else {
				header('Location: index.html');
				exit;

			}

		}

		foreach ($times as $x => $value) {
			if ($x==0) {
				echo $times[$x]." x ";
			} else {
				echo $times[$x]."<br>";
			}
		}

		echo "<br>";

	}

}

echo "<h3>Partidas definidas</h3>";

$sql4 = "SELECT partida_idpartida FROM partida_time WHERE rodada_idrodada = '$idrodada' and gols IS NOT NULL GROUP BY partida_idpartida HAVING Count(*) > 1";
$res4 = mysqli_query($link, $sql4);
$idpartidadef=array();

if ($res4) {
	while ($row = mysqli_fetch_assoc($res4)) {
		$idpartidadef[] = $row["partida_idpartida"];
	}

} else {
	header('Location: index.html');
	exit;
}

if (count($idpartidadef)==0) {
	echo "Nenhum placar foi definido até o momento!<br>";
} else {
	exibir_partidas_definidas($idpartidadef);
}


echo "<br><a href=admin.php>Voltar</a>";


mysqli_close($link);
?>
