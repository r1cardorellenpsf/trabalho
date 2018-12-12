<?php

$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

if (!$link) {
	header('Location: index.html');
	exit;
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

$x =0;

$sql2 = "SELECT COUNT(*) from timenome WHERE rodada_idrodada = '$idrodada'";
$res2 = mysqli_query($link, $sql2);

$sql1 = "SELECT * FROM timenome WHERE rodada_idrodada = '$idrodada'";
$res1 = mysqli_query($link, $sql1);

$time=array();

echo "<style type=text/css>
body{
	background-color: #7CFC00;
}
</style>";

if ($res1 && $res2) {

	while ($row = mysqli_fetch_assoc($res2)) {
		$x = $row["COUNT(*)"];
	}

	echo "<br><h2>Times cadastrados</h2>";
	echo "<h3>".$rodada." rodada</h3>";
	echo "<h3>Numero de times: ".$x."</h3>";

	while ($row = mysqli_fetch_assoc($res1)) {
		$time[] = $row["timenome"];
	}

	if ($x==0) {
		echo "Nenhum time foi cadastrado nesta rodada ainda!";
	} else {
		foreach ($time as $i => $value) {
			echo $time[$i]."<br>";
		}

	}
	echo "<br><br><a href=admin.php>Voltar</a>";

} else {
	header('Location: index.html');
	exit;
}

mysqli_close($link);
?>
