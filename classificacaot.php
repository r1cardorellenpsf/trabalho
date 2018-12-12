<?php

$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

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

#E se nao houver nenhum time?
#$posicao = intval($posicao);
echo "<style type=text/css>
x{color: #7CFC00;}
</style>";
echo "<style type=text/css>
body{
	background-color: #7CFC00;
}
p, address {margin-left: 3em;}
</style>";
echo "<br><h2>".$rodada." rodada</h2>";


$sql1 = "SELECT idtimenome FROM timenome WHERE rodada_idrodada = '$idrodada'";
$idtimes=array();
$res1 = mysqli_query($link, $sql1);
if ($res1) {
	while ($row = mysqli_fetch_assoc($res1)) {
		$idtimes[] = $row["idtimenome"];
	}
} else {
	header('Location: index.html');
	exit;
}

if (count($idtimes)==0) {
	echo "<br><h3>Nenhum time está nesta rodada ainda!</h3>";
} else {
	echo "<br><b>Posicao<x>__</x>Pontos<x>__</x>Jogos<x>__</x>Vitorias<x>__</x>Derrotas<x>__</x>Empates<x>__</x>Time</b><br>";

	$posicoes=array();

	$timessemjogos=array();
	$timespontos=array();
	$timesvitorias=array();
	$timesderrotas=array();
	$timesempates=array();
	$numerojogos=array();
	$timesnome=array();
	foreach($idtimes as $i => $value) {
		$partidastime=array();
		$sql2 = "SELECT partida_idpartida FROM partida_time WHERE timenome_idtimenome = '$idtimes[$i]' and rodada_idrodada = '$idrodada' and gols IS NOT NULL";
		$res2 = mysqli_query($link, $sql2);
		if ($res2) {
			while ($row = mysqli_fetch_assoc($res2)) {
				$partidastime[] = $row["partida_idpartida"];
			}
		} else {
			header('Location: index.html');
			exit;
		}

		if (count($partidastime)==0) {
			$sql03 = "SELECT timenome FROM timenome WHERE idtimenome = '$idtimes[$i]' and rodada_idrodada = '$idrodada'";
			$res03 = mysqli_query($link, $sql03);
			$nometimesemjogo="";
			if ($res03) {
				while ($row = mysqli_fetch_assoc($res03)) {
					$nometimesemjogo = $row["timenome"];
				}
			} else {
				header('Location: index.html');
				exit;
			}
			$timessemjogos[] = $nometimesemjogo;
		} else {
			$sql02 = "SELECT timenome FROM timenome WHERE idtimenome = '$idtimes[$i]' and rodada_idrodada = '$idrodada'";
			$res02 = mysqli_query($link, $sql02);
			$nometime="";
			if ($res02) {
				while ($row = mysqli_fetch_assoc($res02)) {
					$nometime = $row["timenome"];
				}
			} else {
				header('Location: index.html');
				exit;
			}
			$pontostime=0;
			$vitoriastime=0;
			$empatestime=0;
			$derrotastime=0;
			foreach($partidastime as $y => $value) {
				$sql3 = "SELECT pontos FROM partida_time WHERE partida_idpartida = '$partidastime[$y]' and timenome_idtimenome = '$idtimes[$i]' and rodada_idrodada = '$idrodada'";
				$res3 = mysqli_query($link, $sql3);
				if ($res3) {
					while ($row = mysqli_fetch_assoc($res3)) {
						$pontostime = intval($row["pontos"]) + $pontostime;
						if (intval($row["pontos"]) == 3) {
							$vitoriastime = $vitoriastime+1;
						} else {
							if (intval($row["pontos"]) == 1) {
								$empatestime = $empatestime+1;
							} else {
								$derrotastime = $derrotastime+1;
							}
						}
					}
				} else {
					header('Location: index.html');
					exit;
				}
			}
			$id=$idtimes[$i];
			$timespontos[$id] = $pontostime;
			$timesvitorias[$id]= $vitoriastime;
			$timesderrotas[$id]=$derrotastime;
			$timesempates[$id] =$empatestime;
			$numerojogos[$id] = (count($partidastime));
			$timesnome[$id] = $nometime;
		}

	}

	arsort($timespontos, SORT_NUMERIC);

	$x=0;
	foreach($timespontos as $c => $value) {

	#$w=key($timespontos[$c]);
		$x=$x+1;
		$w = array_search($timespontos[$c], $timespontos);
		if ($x <10 && $timespontos[$w] <10) {
			echo "<br><x>____</x><b>$x</b><x>_____</x>$timespontos[$w]<x>_______</x>$numerojogos[$w]<x>_______</x>$timesvitorias[$w]<x>_________</x>$timesderrotas[$w]<x>_______</x>$timesempates[$w]<x>______</x>$timesnome[$w]";
		} else {
			if ($x>=10 && $timespontos[$w] <10) {
				echo "<br><x>___</x><b>$x</b><x>_____</x>$timespontos[$w]<x>_______</x>$numerojogos[$w]<x>_______</x>$timesvitorias[$w]<x>_________</x>$timesderrotas[$w]<x>_______</x>$timesempates[$w]<x>______</x>$timesnome[$w]";

			} else {
				if ($x>=10 && $timespontos[$w] >= 10) {
					echo "<br><x>___</x><b>$x</b><x>_____</x>$timespontos[$w]<x>______</x>$numerojogos[$w]<x>_______</x>$timesvitorias[$w]<x>_________</x>$timesderrotas[$w]<x>_______</x>$timesempates[$w]<x>______</x>$timesnome[$w]";

				} else {
					if ($x<10 && $timespontos[$w] >= 10) {
						echo "<br><x>____</x><b>$x</b><x>_____</x>$timespontos[$w]<x>______</x>$numerojogos[$w]<x>_______</x>$timesvitorias[$w]<x>_________</x>$timesderrotas[$w]<x>_______</x>$timesempates[$w]<x>______</x>$timesnome[$w]";
					}
				}
			}
		}

	}

	$xx=$x;
	foreach($timessemjogos as $d=>$value) {
		$xx=$xx+1;
		if ($xx <10) {
			echo "<br><x>____</x><b>$xx</b><x>_____</x>0<x>_______</x>0<x>_______</x>0<x>_________</x>0<x>_______</x>0<x>______</x>$timessemjogos[$d]";
		} else {
			if ($xx>=10) {
				echo "<br><x>___</x><b>$xx</b><x>_____</x>0<x>_______</x>0<x>_______</x>0<x>_________</x>0<x>_______</x>0<x>______</x>$timessemjogos[$d]";
			}
		}

	}
}

#echo "<br><x>xxx</x><b>10</b><x>xxxxxx</x>1<x>xxxxxx</x>9<x>xxxxxxx</x>5<x>xxxxxxxxx</x>4<x>xxxxxxx</x>5<x>xxxxxx</x>Teste";

echo "<br><br><br><a href=feed.php>Voltar</a>";


mysqli_close($link);
?>