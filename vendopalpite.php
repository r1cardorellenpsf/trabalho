<?php

$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

echo "<style type=text/css>
body{
	background-color: #7CFC00;
}
o{
	color: #666666;
}
</style>";


$cookieLogin = $_COOKIE['login'];
$cookieRodada = $_COOKIE['rodada'];

$cookieLogin = $_COOKIE['login'];

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

function transformando($xx) {
	if ($xx<0) {
		return -($xx);
	} else {
		return $xx;
	}
}

function exibir_partidas_definidas($partida) {

	$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

	$cookieLogin = $_COOKIE['login'];

	$sql1 = "SELECT idusuario FROM usuario WHERE login = '$cookieLogin'";
	$res1 = mysqli_query($link, $sql1);
	$idusuario = "";

	if ($res1) {
		while ($row = mysqli_fetch_assoc($res1)) {
			$idusuario = $row["idusuario"];
		}
	} else {
		echo $idusuario;
		exit;
	}

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
		$pontospalpite = array();
		$gols = array();

		foreach ($idtimes as $y => $value) {

			$sql3 = "SELECT timenome FROM timenome WHERE idtimenome = $idtimes[$y]";
			$res3 = mysqli_query($link, $sql3);

			$sql4 = "SELECT palpite FROM palpite WHERE usuario_idusuario = '$idusuario' and 
			partida_time_partida_idpartida = '$partida[$i]' and partida_time_time_idtime = '$idtimes[$y]'";
			$res4 = mysqli_query($link, $sql4);

			$sql5 = "SELECT gols FROM partida_time WHERE partida_idpartida = '$partida[$i]' and timenome_idtimenome = $idtimes[$y]";
			$res5 = mysqli_query($link, $sql5);

			if ($res3 && $res4 && $res5) {
				while ($row = mysqli_fetch_assoc($res3)) {
					$times[] = $row["timenome"];
				}
				while ($row = mysqli_fetch_assoc($res4)) {
					$pontospalpite[] = $row["palpite"];
				}
				while ($row = mysqli_fetch_assoc($res5)) {
					$gols[] = $row["gols"];
				}

			} else {
				echo $times;
				echo $pontospalpite;
				exit;

			}

		}

		if (count($pontospalpite)==0) {

			foreach ($times as $x => $value) {

				if ($x==0) {
					echo $times[$x];
					echo " <b>".$gols[$x]." x";
				} else {
					echo " ".$gols[$x]."</b> ";
					echo $times[$x]."<br>";
					

				}
			}

		} else {
			$pont=0;
			foreach ($times as $x => $value) {

				if ($x==0) {
					echo $times[$x];
					echo "  (".$pontospalpite[$x].") ";
					echo "  <b>".$gols[$x]." x</b>";
					$pont=transformando($pontospalpite[$x]-$gols[$x])+$pont;
					
				} else {
					echo "  <b>".$gols[$x];
					echo "</b>  (".$pontospalpite[$x].") ";
					echo $times[$x]."<br>";
					$pont=transformando($pontospalpite[$x]-$gols[$x])+$pont;


				}

			}
		
			echo "<o>Sua pontuacao na partida: $pont</o><br>";


		}

		echo "<br>";

	}
}

function exibir_partidas_nao_definidas($partida) {

	$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

	$cookieLogin = $_COOKIE['login'];

	$sql1 = "SELECT idusuario FROM usuario WHERE login = '$cookieLogin'";
	$res1 = mysqli_query($link, $sql1);
	$idusuario = "";

	if ($res1) {
		while ($row = mysqli_fetch_assoc($res1)) {
			$idusuario = $row["idusuario"];
		}
	} else {
		echo $idusuario;
		exit;
	}

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
		$pontospalpite = array();

		foreach ($idtimes as $y => $value) {

			$sql3 = "SELECT timenome FROM timenome WHERE idtimenome = $idtimes[$y]";
			$res3 = mysqli_query($link, $sql3);

			$sql4 = "SELECT palpite FROM palpite WHERE usuario_idusuario = '$idusuario' and 
			partida_time_partida_idpartida = '$partida[$i]' and partida_time_time_idtime = '$idtimes[$y]'";

			$res4 = mysqli_query($link, $sql4);

			if ($res3 && $res4) {
				while ($row = mysqli_fetch_assoc($res3)) {
					$times[] = $row["timenome"];
				}
				while ($row = mysqli_fetch_assoc($res4)) {
					$pontospalpite[] = $row["palpite"];
				}

			} else {
				echo $times;
				echo $pontospalpite;
				exit;

			}

		}

		foreach ($times as $x => $value) {

			if ($x==0) {
				echo $times[$x];
				echo " (".$pontospalpite[$x].") <b>x</b>";
			} else {
				echo " (".$pontospalpite[$x].") ";
				echo $times[$x];
				

			}
		}

		echo "<br><br>";

	}
}

$idrodada="";
$sql0 = "SELECT idrodada from rodada WHERE rodada = '$cookieRodada'";
$res0 = mysqli_query($link, $sql0);
if ($res0) {
	while ($row = mysqli_fetch_assoc($res0)) {
		$idrodada = $row["idrodada"];
	}
} else {
	header('Location: index.html');
	exit;
}

echo "<br><h2>$cookieRodada rodada</h2>";

echo "<h3>Partidas ja definidas</h3>";

$sql3 = "SELECT partida_time_partida_idpartida FROM palpite WHERE usuario_idusuario = '$idusuario' and rodada_idrodada = '$idrodada' and palpiteponto IS NOT NULL GROUP BY partida_time_partida_idpartida HAVING Count(*) > 1";

$res3 = mysqli_query($link, $sql3);
$partidasjadef=array();
if ($res3) {
	while ($row = mysqli_fetch_assoc($res3)) {
		$partidasjadef[] = $row["partida_time_partida_idpartida"];
	}
} else {
	header('Location: index.html');
	exit;
}

if (count($partidasjadef) == 0) {
	echo "<i>Nenhuma partida foi definida ainda!</i><br><br>";

	$sql35 = "SELECT partida_time_partida_idpartida FROM palpite WHERE rodada_idrodada = '$idrodada' and palpiteponto IS NOT NULL GROUP BY partida_time_partida_idpartida HAVING Count(*) > 1";

	$res35 = mysqli_query($link, $sql35);
	$partidasdef=array();
	if ($res35) {
		while ($row = mysqli_fetch_assoc($res35)) {
			$partidasdef[] = $row["partida_time_partida_idpartida"];
		}
	} else {
		header('Location: index.html');
		exit;
	}

	exibir_partidas_definidas($partidasdef);

} else {
	echo "<i>Entre parenteses o seu palpite para cada time na partida</i><br><br>";
	exibir_partidas_definidas($partidasjadef);
	echo "<i><o>Obs: quanto menor a sua pontuacao, melhor o seu desempenho!</o></i><br><br>";
}

$sql2 = "SELECT partida_time_partida_idpartida FROM palpite WHERE usuario_idusuario = '$idusuario' and rodada_idrodada = '$idrodada' and palpiteponto IS NULL GROUP BY partida_time_partida_idpartida HAVING Count(*) > 1";
$res2 = mysqli_query($link, $sql2);
$partidascompalpite=array();
if ($res2) {
	while ($row = mysqli_fetch_assoc($res2)) {
		$partidascompalpite[] = $row["partida_time_partida_idpartida"];
	}
} else {
	header('Location: index.html');
	exit;
}

if (count($partidascompalpite) == 0) {
	echo "<br><h3>Partidas ainda nao definidas</h3>";
	echo "<i>Voce ainda nao fez nenhum palpite!</i><br><br>";

} else {

	echo "<h3>Partidas ainda nao definidas</h3>";
	echo "<i>Seus palpites</i><br><br>";
	exibir_partidas_nao_definidas($partidascompalpite);
}

echo "<br><a href=feed.php>Voltar</a>";

mysqli_close($link);

?>