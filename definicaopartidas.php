<?php

echo "<style type=text/css>
body{
	background-color: #7CFC00;
}
</style>";

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

$y=0;
$sql = "SELECT COUNT(*) from partida WHERE rodada_idrodada = '$idrodada'";
$res = mysqli_query($link, $sql);

if ($res) {
	while ($row = mysqli_fetch_assoc($res)) {
		$y = $row["COUNT(*)"];
	}
} else {
	header('Location: index.html');
	exit;
}

echo "<style type=text/css>
    p{
        color: #8c8c8c;
    }
    </style>";
echo "<br><h2>Definicao de partidas</h2>";
echo "<h3>".$rodada." rodada</h3>";
echo "<b>Numero de partidas já"; 
echo "<br>programadas da rodada: ".$y."</b>";

echo "<br><br><br>
<form method=POST action=definindopartida.php>
Time 1:
<input type=text name=time1 style=margin-left:0.3%>
<br>    
<br>
Time 2:
<input type=text name=time2 style=margin-left:0.3%>
<br><br>
<a href=admin.php>Voltar</a><input type =submit value=Definir style=margin-left:8.6%>
</form>";

?>