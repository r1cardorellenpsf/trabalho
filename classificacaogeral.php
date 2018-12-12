<?php

$link = mysqli_connect("127.0.0.1", "root", "", "cartola");


function transformandoint($xx) {
	if ($xx == 0.5) {
		return $xx-0.5;
	} else {
		if (($xx%2)==0) {
			return $xx;
		} else {
			$x=$xx-0.5;
			return $x;

		}
	}
}


$rodada = $_COOKIE['rodada'];
$idrodada="";
$sql01 = "SELECT idrodada from rodada WHERE rodada = '$rodada'";
$res01 = mysqli_query($link, $sql01);
if ($res01) {
	while ($row = mysqli_fetch_assoc($res01)) {
		$idrodada = $row["idrodada"];
	}
} else {
	header('Location: index.html');
	exit;
}

$estado="";
$sql03 = "SELECT estado from rodada WHERE rodada = '$rodada'";
$res03 = mysqli_query($link, $sql03);
if ($res03) {
	while ($row = mysqli_fetch_assoc($res03)) {
		$estado = $row["estado"];
	}
} else {
	header('Location: index.html');
	exit;
}

echo "<style type=text/css>
x{color: #7CFC00;}
</style>";
echo "<style type=text/css>
body{
	background-color: #7CFC00;
}
p, address {margin-left: 3em;}
t{
	color: #666666;
}
</style>";
echo "<br><h2>Classificacao geral</h2>";

$sql02 = "SELECT timenome_idtimenome FROM palpite_posicao WHERE estado IS NOT NULL";
$res02 = mysqli_query($link, $sql02);
$timesdef=array();
if ($res02) {
	while ($row = mysqli_fetch_assoc($res02)) {
		$timesdef[] = $row["timenome_idtimenome"];
	}
} else {
	header('Location: index.html');
	exit;
}

if (count($timesdef)==0) {
	echo "<br><b>Posicao<x>__</x>Acertos<x>__</x>Pontos relativos<x>__</x>Palpites/Partida<x>__</x>Palpiteiro</b><br>";
	$sql1 = "SELECT idusuario FROM usuario";
	$res1 = mysqli_query($link, $sql1);
	$idusuarios=array();
	if ($res1) {
		while ($row = mysqli_fetch_assoc($res1)) {
			$idusuarios[] = $row["idusuario"];
		}
	} else {
		header('Location: index.html');
		exit;
	}

	$numpalpites=array();
	$pontosrelpalpites=array();
	$acertospalpites=array();
	$nomespalpiteiros=array();

	$nomessempalpite=array();
	foreach($idusuarios as $i => $value) {
		$sql2 = "SELECT palpitepontorel FROM palpite WHERE palpitepontorel IS NOT NULL and usuario_idusuario = '$idusuarios[$i]'";
		$res2 = mysqli_query($link, $sql2);

		$sql3 = "SELECT idpalpite FROM palpite WHERE palpitepontorel IS NOT NULL and usuario_idusuario = '$idusuarios[$i]'";
		$res3 = mysqli_query($link, $sql3);

		$sql4 = "SELECT login FROM usuario WHERE idusuario = '$idusuarios[$i]'";
		$res4 = mysqli_query($link, $sql4);

		$sql5 = "SELECT palpiteponto FROM palpite WHERE palpitepontorel IS NOT NULL and usuario_idusuario = '$idusuarios[$i]'";
		$res5 = mysqli_query($link, $sql5);

		$y=$idusuarios[$i];

		$acertos=array();
		$pontos=array();
		$num=array();
		$nome="";
		if ($res2 && $res3 && $res4 && $res5) {
			while ($row = mysqli_fetch_assoc($res2)) {
				$pontos[] = $row["palpitepontorel"];
			}
			while ($row = mysqli_fetch_assoc($res3)) {
				$num[] = $row["idpalpite"];
			}
			while ($row = mysqli_fetch_assoc($res4)) {
				$nome = $row["login"];
			}
			while ($row = mysqli_fetch_assoc($res5)) {
				$acertos[] = $row["palpiteponto"];
			}
		} else {
			header('Location: index.html');
			exit;
		}

		if (count($num) == 0) {
			$nomessempalpite[] = $nome;

		} else {
			$pontostotal=0;
			foreach($pontos as $ii => $value) {
				$pontostotal = intval($pontos[$ii])+$pontostotal;
			}

			$acertostotal=0;
			foreach($acertos as $iii => $value) {
				$acertostotal = intval($acertos[$iii])+$acertostotal;
			}

			$pontosrelpalpites[$y] = $pontostotal;
			$numpalpites[$y] = (count($num))/2;
			$nomespalpiteiros[$y] = $nome;
			$acertospalpites[$y] = transformandoint(($acertostotal)/2);

		}

	}

	asort($pontosrelpalpites, SORT_NUMERIC);

	$x=0;
	foreach($pontosrelpalpites as $p => $value) {
		$w = array_search($pontosrelpalpites[$p], $pontosrelpalpites);
		$x=$x+1;
		if ($x<10 && $pontosrelpalpites[$w] <10) {
			echo "<br><x>___</x><b>$x</b><x>_______</x>$acertospalpites[$w]<x>___________</x>$pontosrelpalpites[$w]<x>_______________</x>$numpalpites[$w]<x>_________</x>$nomespalpiteiros[$w]";
		} else {
			if ($x>=10 && $pontosrelpalpites[$w] < 10) {
				echo "<br><x>__</x><b>$x</b><x>_______</x>$acertospalpites[$w]<x>___________</x>$pontosrelpalpites[$w]<x>_______________</x>$numpalpites[$w]<x>_________</x>$nomespalpiteiros[$w]";
			} else {
				if ($x>=10 && $pontosrelpalpites[$w] >= 10) {
					echo "<br><x>__</x><b>$x</b><x>_______</x>$acertospalpites[$w]<x>__________</x>$pontosrelpalpites[$w]<x>_______________</x>$numpalpites[$w]<x>_________</x>$nomespalpiteiros[$w]";
				} else {
					if ($x<10 && $pontosrelpalpites[$w] >= 10) {
						echo "<br><x>___</x><b>$x</b><x>_______</x>$acertospalpites[$w]<x>___________</x>$pontosrelpalpites[$w]<x>_______________</x>$numpalpites[$w]<x>_________</x>$nomespalpiteiros[$w]";
					}
				}
			}
		}
	}

	$xx = $x;
	foreach($nomessempalpite as $s => $value) {
		$xx = $xx+1;
		if ($xx<10) {
			echo "<br><x>___</x><b>$xx</b><x>_______</x>0<x>___________</x>0<x>_______________</x>0<x>_________</x>$nomessempalpite[$s]";
		} else {
			echo "<br><x>__</x><b>$xx</b><x>_______</x>0<x>___________</x>0<x>_______________</x>0<x>_________</x>$nomessempalpite[$s]";

		}

	}


} else {
	echo "<br><b>Posicao<x>__</x>Acertos<x>__</x>Pontos relativos<x>__</x>Palpites/Rodada<x>__</x>Palpiteiro</b><br>";
}
#echo "<br><x>___</x><b>1</b><x>_______</x>8<x>___________</x>1<x>_______________</x>$numpalpites[$w]<x>_________</x>$nomespalpiteiros[$w]";

#echo "<br><b>Posicao<x>__</x>Pontos/Partida<x>__</x>Palpites/Partida<x>__</x>Pontos/Time<x>__</x>Palpiteiro</b><br>";
#echo "<br><x>___</x><b>1</b><x>_________</x>10<x>______________</x>0<x>_________</x>Teste";
#echo "<br><b>Posicao<x>__</x>Pontos/Partida<x>__</x>Palpites/Partida<x>__</x>Pontos/Time<x>__</x>Palpiteiro</b><br>";
echo "<br><br><br><t>Obs.: devido a uma formula inteligente, quanto menos <br>pontos relativos voce tiver, melhor sera o seu desempenho!</t>";

echo "<br><br><a href=feed.php>Voltar</a>";


mysqli_close($link);
?>