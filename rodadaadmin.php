<?php

$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

echo "<style type=text/css>
body{
	background-color: #7CFC00;
}
</style>";

setcookie("rodadaadm", "");

$sql1 = "SELECT rodada FROM rodada";
$res1 = mysqli_query($link, $sql1);
$rodadas=array();

if ($res1) {
	while ($row = mysqli_fetch_assoc($res1)) {
		$rodadas[] = $row["rodada"];
	}

} else {
	header('Location: index.html');
	exit;
}

if (count($rodadas)==0) {
	$sql2 = "INSERT INTO rodada (rodada, estado) VALUES ('Primeira', '0')";
	$res2 = mysqli_query($link, $sql2);
	if ($res2) {
	} else {
		header('Location: index.html');
		exit;
	}
} 

$sql1 = "SELECT rodada FROM rodada";
$res1 = mysqli_query($link, $sql1);
$rodadas=array();

if ($res1) {
	while ($row = mysqli_fetch_assoc($res1)) {
		$rodadas[] = $row["rodada"];
	}

} else {
	header('Location: index.html');
	exit;
}

echo "<br>
<h2>Primeiro, escolha a rodada na qual voce deseja fazer alteracoes</h3><br>";

echo "<form action=admin.php method=post>
<select size=1 name=rodada>
<option selected value=selecionar>Selecionar Rodada</option>";

foreach ($rodadas as $i => $value) {
	echo "<option value=$rodadas[$i]>$rodadas[$i]</option>";
	setcookie("rodadaadm", $rodadas[$i]);
}

echo "	</select>

<input type=submit value=Enviar style=margin-left:0.8%>

</form>";

mysqli_close($link);

?>