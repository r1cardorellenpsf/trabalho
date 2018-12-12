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

$x = 0;
$sql1 = "SELECT COUNT(*) from timenome WHERE rodada_idrodada = '$idrodada'";
$res1 = mysqli_query($link, $sql1);

if ($res1) {
	while ($row = mysqli_fetch_assoc($res1)) {
		$x = $row["COUNT(*)"];
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
echo "<br><h2>Cadastro de times</h2>";
echo "<h3>".$rodada." rodada</h3>";
echo "<h3>Numero de times: ".$x."</h3>";
echo "
<form method=POST action=cadastrandotime.php>
Time:
<input type=text name=time>
<br><br>
<a href=admin.php>Voltar</a><input type =submit value=Cadastrar style=margin-left:7.5%>
</form>";

?>