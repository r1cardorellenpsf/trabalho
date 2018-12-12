<?php

# echo "<a href=definindoplacar.php>Esqueci minha senha</a>";

$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

echo "<style type=text/css>
body{
	background-color: #7CFC00;
}
</style>";

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

echo "<br><h2>Definicao de placares</h2>";
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

	echo "
	<form method=POST action=definindoplacar.php>";

	#<input type=radio name=opcao value=time> Ver times<br>

	foreach ($idpartida as $i => $value) {
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

		echo "<input type=radio name=partida value=$idpartida[$i]> ";

		foreach ($times as $x => $value) {

			
			if ($x==0) {
				echo $times[$x]." x ";
			} else {
				echo $times[$x]."<br>";
			}
		}

		echo "<br>";

	}

	echo "<button href=definindoplacar.php method=submit>Proximo </button>
	</form>";
	
}

echo "<br><br><a href=admin.php>Voltar</a>";

?>