<?php

$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

echo "<style type=text/css>
body{
	background-color: #7CFC00;
}
</style>";

setcookie("partida", "");
setcookie("time1", "");
setcookie("time2", "");

echo "<h2>Placar da partida</h2>";

$idpartida = $_POST['partida'];

setcookie("partida", $idpartida);

$idtimes=array();
$sql2 = "SELECT timenome_idtimenome FROM partida_time WHERE partida_idpartida = $idpartida";
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
	if ($y==0) {
		setcookie("time1", $idtimes[$y]);
	} else {
		setcookie("time2", $idtimes[$y]);
	}
	
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

echo "<form method=post action=placar.php><br>";

foreach ($times as $x => $value) {

	if ($x==0) {
		echo $times[$x].": "."<input type=number name=gols1>";
	} else {
		echo "   ".$times[$x].": "."<input type=number name=gols2>";
	}
}
echo "<br><br><br><input type=submit value=Definir>";

echo "<br></form>";

?>