<?php
$link = mysqli_connect("127.0.0.1", "root", "", "cartola");
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

$sql1="UPDATE rodada SET estado = '0' WHERE rodada.idrodada = '$idrodada'";
$res1 = mysqli_query($link, $sql1);
if ($res1) {
	header("Location: admin.php");
} else {
	header('Location: index.html');
	exit;
}

mysqli_close($link);

?>