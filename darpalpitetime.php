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

function exibir_times($times) {

	$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

	$cookieLogin = $_COOKIE['login'];
	$rodada = $_COOKIE['rodada'];

	$sql4 = "SELECT idusuario FROM usuario WHERE login = '$cookieLogin'";
	$res4 = mysqli_query($link, $sql4);
	$idusuario = "";
	if ($res4) {
		while ($row = mysqli_fetch_assoc($res4)) {
			$idusuario = $row["idusuario"];
		}
	} else {
		echo "$idusuario";
		exit;
	}

	$idrodada="";
	$sql0 = "SELECT idrodada from rodada WHERE rodada = '$rodada'";
	$res0 = mysqli_query($link, $sql0);
	if ($res0) {
		while ($row = mysqli_fetch_assoc($res0)) {
			$idrodada = $row["idrodada"];
		}
	} else {
		echo "$idrodada";
		exit;
	}

	$posicoes=array();
	$timesposicao=array();
	$idtimespos=array();

	echo "
	<form method=POST action=definindopalpitetime.php>";

	foreach ($times as $i => $value) {

		$sql3 = "SELECT palpite_posicao FROM palpite_posicao WHERE usuario_idusuario = '$idusuario' and timenome_idtimenome = '$times[$i]' and rodada_idrodada = '$idrodada' and estado is NULL";
		$res3 = mysqli_query($link, $sql3);
		$posicao="";
		if ($res3) {
			while ($row = mysqli_fetch_assoc($res3)) {
				$posicoes[] = $row["palpite_posicao"];
				$posicao=$row["palpite_posicao"];
			}
		} else {
			echo "$idrodada";
			exit;
		}

		$timenome="";
		$sql2 = "SELECT timenome FROM timenome WHERE idtimenome = $times[$i]";
		$res2 = mysqli_query($link, $sql2);

		if ($res2) {
			while ($row = mysqli_fetch_assoc($res2)) {
				$timenome = $row["timenome"];
			}

		} else {
			echo "$timenome";
			exit;
		}

		
		if (count($posicoes) == 0) {
			echo "<input type=radio name=palpite value=$times[$i]>";
			echo "$timenome <br>";
		} else {
			$timesposicao["$posicao"]="$timenome";
			$idtimespos["$posicao"]="$times[$i]";
			#echo "(".$posicao.") $timenome<br>";
		}
	}

	sort($posicoes, SORT_NUMERIC);

	foreach($posicoes as $t => $value) {
		$y="";
		$y=$posicoes[$t];
		echo "<input type=radio name=palpite value=$idtimespos[$y]>";
		$x="";
		$x=$posicoes[$t];
		#echo "(".$posicoes[$t].") $timesposicao[".$posicoes[$t]."]<br>";
		echo "(".$posicoes[$t].") $timesposicao[$x]<br>";
	}

	echo "<br>";
}

$idrodada="";
$sql0 = "SELECT idrodada from rodada WHERE rodada = '$rodada'";
$res0 = mysqli_query($link, $sql0);
if ($res0) {
	while ($row = mysqli_fetch_assoc($res0)) {
		$idrodada = $row["idrodada"];
	}
} else {
	echo "$idrodada";
	exit;
}

echo "<br><h2>Escolha o time para dar ou alterar seu palpite!</h2>";
echo "<h3>".$rodada." rodada</h3>";

$sql1 = "SELECT idtimenome FROM timenome WHERE rodada_idrodada = '$idrodada'";
$res1 = mysqli_query($link, $sql1);
$idtimenome=array();
#idpartida=idtimenome

#$defpartidas=array();

if ($res1) {
	while ($row = mysqli_fetch_assoc($res1)) {
		$idtimenome[] = $row["idtimenome"];
	}
} else {
	echo "$idtimenome";
	exit;
}

if (count($idtimenome)==0) {
	echo "Nenhum time foi cadastrado na rodada até o momento!";
} else {

	$sql4 = "SELECT idusuario FROM usuario WHERE login = '$cookieLogin'";
	$res4 = mysqli_query($link, $sql4);
	$idusuario = "";

	if ($res4) {
		while ($row = mysqli_fetch_assoc($res4)) {
			$idusuario = $row["idusuario"];
		}

	} else {
		echo "$idusuario";
		exit;
	}

	$sql5 = "SELECT idpalpite_posicao FROM palpite_posicao WHERE usuario_idusuario = '$idusuario' and estado IS NULL and rodada_idrodada = '$idrodada'";
	$res5 = mysqli_query($link, $sql5);
	$palpitesposicao=array();
	#palpites=palpitesposicao

	if ($res5) {
		while ($row = mysqli_fetch_assoc($res5)) {
			$palpitesposicao[] = $row["idpalpite_posicao"];
		}

	} else {
		echo "$palpitesposicao";
		exit;
	}

	if (count($palpitesposicao)==0) {
		echo "<h3>Times sem o seu palpite</h3>";
		exibir_times($idtimenome);
		echo "<button href=definindopalpitetime.php method=submit>Palpitar </button> <br><br><br><a href=feed.php>Voltar</a>
		</form>";
	} else {

		$sql6 = "SELECT timenome_idtimenome FROM palpite_posicao WHERE usuario_idusuario = '$idusuario' and rodada_idrodada = '$idrodada' and estado IS NULL";
		#$sql6 = "SELECT timenome_idtimenome FROM palpite_posicao WHERE usuario_idusuario = '$idusuario' and rodada_idrodada = '$idrodada' and estado IS NULL GROUP BY partida_time_partida_idpartida HAVING Count(*) > 1";

		$res6 = mysqli_query($link, $sql6);
		$timescompalpite=array();
		#partidascompalpite=timescompalpite

		if ($res6) {
			while ($row = mysqli_fetch_assoc($res6)) {
				$timescompalpite[] = $row["timenome_idtimenome"];
			}

		} else {
			header('Location: index.html');
			exit;
		}

		if (count($idtimenome) == (count($timescompalpite))) {
			echo "<h3>Times com o seu palpite</h3>";

			exibir_times($timescompalpite);

			echo "<br><button href=definindopalpitetime.php method=submit>Palpitar </button> <br><br><br><a href=feed.php>Voltar</a>
			</form>";

		} else {

			$timessempalpite=array();
			#partidassempalpite=timessempalpite

			foreach ($idtimenome as $t => $value) {

				$x=0;

				foreach ($timescompalpite as $q => $value) {
					if ($idtimenome[$t] == $timescompalpite[$q]) {
						$x=$x+1;
					}
				}
				if ($x == 0) {
					$timessempalpite[] = $idtimenome[$t];
				}
			}

			echo "<h3>Times sem o seu palpite</h3>";

			exibir_times($timessempalpite);

			echo "<h3>Times com o seu palpite</h3>";
			echo "<i>Entre parenteses a posicao que voce escolheu<br>
			para cada time</i><br><br>";

			exibir_times($timescompalpite);

			echo "<br><button href=definindopalpitetime.php method=submit>Palpitar </button> <br><br><br><a href=feed.php>Voltar</a>
			</form>";

		}
	}
}

mysqli_close($link);

?>