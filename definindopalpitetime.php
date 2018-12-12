<?php

$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

echo "<style type=text/css>
body{
	background-color: #7CFC00;
}
</style>";

setcookie("time", "");

$idtime = $_POST['palpite'];

$time="";
$sql2 = "SELECT timenome FROM timenome WHERE idtimenome = $idtime";
$res2 = mysqli_query($link, $sql2);

if ($res2) {
	while ($row = mysqli_fetch_assoc($res2)) {
		$time = $row["timenome"];
	}

} else {
	header('Location: index.html');
	exit;
}

setcookie("time", $idtime);

$rodada = $_COOKIE['rodada'];

echo "<br><h2>".$rodada." rodada</h2>";

echo "<h3>Que posicao voce acha que<br>".$time." ocupara?</h3>";

echo "<form method=post action=palpitetime.php><br>";

echo "Posicao: "."<input type=number name=posicao>";

echo "<br><br><input type=submit value=Palpitar style=margin-left:10.8%>";

echo "</form>";

mysqli_close($link);

?>