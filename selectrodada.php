<?php

$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

echo "<style type=text/css>
body{
	background-color: #7CFC00;
}
</style>";

setcookie("rodada", "");

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
<h2>Primeiro, escolha a rodada</h3><br>";

echo "<form action=feed.php method=post>
<select size=1 name=rodada>
<option selected value=selecionar>Selecionar Rodada</option>";

foreach ($rodadas as $i => $value) {
	echo "<option value=$rodadas[$i]>$rodadas[$i]</option>";
	setcookie("rodada", $rodadas[$i]);
}

echo "	</select>

<input type=submit value=Enviar style=margin-left:0.8%>

</form>";

mysqli_close($link);

?>