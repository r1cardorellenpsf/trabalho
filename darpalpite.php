<?php

# echo "<a href=definindoplacar.php>Esqueci minha senha</a>";

$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

$cookieLogin = $_COOKIE['login'];
$rodada = $_COOKIE['rodada'];

echo "<style type=text/css>
body{
	background-color: #7CFC00;
}
</style>";

function exibir_times($partida) {

	$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

	echo "
	<form method=POST action=definindopalpite.php>";

	foreach ($partida as $i => $value) {

		$cookieLogin = $_COOKIE['login'];
		$sql02 = "SELECT idusuario FROM usuario WHERE login = '$cookieLogin'";
		$res02 = mysqli_query($link, $sql02);
		$idusuario = "";

		if ($res02) {
			while ($row = mysqli_fetch_assoc($res02)) {
				$idusuario = $row["idusuario"];
			}

		} else {
			header('Location: index.html');
			exit;
		}

		$idtimes=array();
		$sql2 = "SELECT timenome_idtimenome FROM partida_time WHERE partida_idpartida = $partida[$i]";
		$res2 = mysqli_query($link, $sql2);

		if ($res2) {
			while ($row = mysqli_fetch_assoc($res2)) {
				$idtimes[] = $row["timenome_idtimenome"];
			}

		} else {
			header("Location: index.html");
			exit;
		}

		$times = array();
		$palpites=array();

		foreach ($idtimes as $y => $value) {

			$sql3 = "SELECT timenome FROM timenome WHERE idtimenome = $idtimes[$y]";
			$res3 = mysqli_query($link, $sql3);

			$sql01 = "SELECT palpite FROM palpite WHERE partida_time_partida_idpartida = '$partida[$i]' and partida_time_time_idtime = '$idtimes[$y]' and usuario_idusuario = '$idusuario'";
			$res01 = mysqli_query($link, $sql01);

			if ($res3 && $res01) {
				while ($row = mysqli_fetch_assoc($res3)) {
					$times[] = $row["timenome"];
				}
				while ($row = mysqli_fetch_assoc($res01)) {
					$palpites[] = $row["palpite"];
				}

			} else {
				header("Location: index.html");
				exit;

			}

		}

		echo "<input type=radio name=palpite value=$partida[$i]> ";

		foreach ($times as $x => $value) {

			if (count($palpites)==0) {
				if ($x==0) {
					echo $times[$x]." <b>x</b> ";
				} else {
					echo $times[$x]."<br>";
				}

			} else {
				if ($x==0) {
					echo $times[$x]." (".$palpites[$x].") <b>x</b> ";
				} else {
					echo "(".$palpites[$x].") ".$times[$x]."<br>";
				}

			}
		}

		echo "<br>";

	}
}

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

echo "<br><h2>Escolha a partida para dar ou alterar seu palpite!</h2>";
echo "<h3>".$rodada." rodada</h3>";

$sql1 = "SELECT partida_idpartida FROM partida_time WHERE rodada_idrodada = '$idrodada' and gols IS NULL GROUP BY partida_idpartida HAVING Count(*) > 1";
$res1 = mysqli_query($link, $sql1);
$idpartida=array();

$defpartidas=array();

if ($res1) {
	while ($row = mysqli_fetch_assoc($res1)) {
		$idpartida[] = $row["partida_idpartida"];
	}
} else {
	header('Location: index.html');
	exit;
}

if (count($idpartida)==0) {
	echo "Nenhuma partida da rodada foi programada até o momento!";
} else {

	$sql4 = "SELECT idusuario FROM usuario WHERE login = '$cookieLogin'";
	$res4 = mysqli_query($link, $sql4);
	$idusuario = "";

	if ($res4) {
		while ($row = mysqli_fetch_assoc($res4)) {
			$idusuario = $row["idusuario"];
		}

	} else {
		header('Location: index.html');
		exit;
	}

	$sql5 = "SELECT idpalpite FROM palpite WHERE usuario_idusuario = '$idusuario' and palpiteponto IS NULL and rodada_idrodada = '$idrodada'";
	$res5 = mysqli_query($link, $sql5);
	$palpites=array();

	if ($res5) {
		while ($row = mysqli_fetch_assoc($res5)) {
			$palpites[] = $row["idpalpite"];
		}

	} else {
		header('Location: index.html');
		exit;
	}

	if (count($palpites)==0) {
		echo "<h3>Partidas sem o seu palpite</h3>";
		exibir_times($idpartida);
		echo "<button href=definindopalpite.php method=submit>Palpitar </button> <br><br><br><a href=feed.php>Voltar</a>
		</form>";
	} else {

		$sql6 = "SELECT partida_time_partida_idpartida FROM palpite WHERE usuario_idusuario = '$idusuario' and rodada_idrodada = '$idrodada' and palpiteponto IS NULL GROUP BY partida_time_partida_idpartida HAVING Count(*) > 1";

		$res6 = mysqli_query($link, $sql6);
		$partidascompalpite=array();

		if ($res6) {
			while ($row = mysqli_fetch_assoc($res6)) {
				$partidascompalpite[] = $row["partida_time_partida_idpartida"];
			}

		} else {
			header('Location: index.html');
			exit;
		}

		if (count($idpartida) == (count($partidascompalpite)/2)) {
			echo "<h3>Partidas com o seu palpite</h3>";

			exibir_times($partidascompalpite);

			echo "<br><button href=definindopalpite.php method=submit>Palpitar </button> <br><br><br><a href=feed.php>Voltar</a>
			</form>";

		} else {

			$partidassempalpite=array();

			foreach ($idpartida as $t => $value) {

				$x=0;

				foreach ($partidascompalpite as $q => $value) {

					if ($idpartida[$t] == $partidascompalpite[$q]) {
						$x=$x+1;
					}

				}

				if ($x == 0) {
					$partidassempalpite[] = $idpartida[$t];
				}
			}

			if (count($partidassempalpite) ==0) {
			} else {
				echo "<h3>Partidas sem o seu palpite</h3>";
				exibir_times($partidassempalpite);
			}

			echo "<h3>Partidas com o seu palpite</h3>";
			echo "<i>Entre parenteses o seu palpite para cada time na partida</i><br><br>";

			exibir_times($partidascompalpite);

			echo "<br><button href=definindopalpite.php method=submit>Palpitar </button><br><br><br> <a href=feed.php>Voltar</a>
			</form>";

		}
	}
}

mysqli_close($link);

?>