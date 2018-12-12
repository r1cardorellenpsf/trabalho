<?php

$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

if (!$link) {
	header('Location: index.html');
	exit;
}

$cookieNome = $_COOKIE['nome'];
$cookieLogin = $_COOKIE['login'];

echo "   <style type=text/css>
p{
	color: #666666;
}
</style>";

if ($cookieNome != "") {
	echo "<style type=text/css>
	body{
		background-color: #7CFC00;
	}
	x{color: #7CFC00}
	</style>";
	echo "<br><h2>Bem vindo, ".$cookieNome."!</h2>";


	echo "<h3>O que deseja fazer?</h3>";

	$rodada = $_COOKIE['rodada'];
	$estado="";
	$sql01 = "SELECT estado from rodada WHERE rodada = '$rodada'";
	$res01 = mysqli_query($link, $sql01);
	if ($res01) {
		while ($row = mysqli_fetch_assoc($res01)) {
			$estado = $row["estado"];
		}
	} else {
		header('Location: index.html');
		exit;
	}

	if (intval($estado)==0) {
		echo "
		<form method=POST action=opcaousuario.php>
		<input type=radio name=opcao value=darpalpite> Dar um palpite para partida<br>
		<input type=radio name=opcao value=darpalpitetime> Dar um palpite para time<br>
		<input type=radio name=opcao value=classificacaot> Ver classificacao dos times<br>
		<input type=radio name=opcao value=classificacaop> Ver classificacao dos palpiteiros<br><x>___-</x>nesta rodada<br>
		<input type=radio name=opcao value=classificacaogeral> Ver classificacao dos palpiteiros<br><x>___-</x>em todas as rodadas<br>
		<input type=radio name=opcao value=verpalpite> Ver meus palpites<br>

		<br><button href=opcaousuario.php method=submit>Proximo </button>
		</form>	
		";

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

		$sql1 = "SELECT idusuario FROM usuario WHERE login = '$cookieLogin'";
		$res1 = mysqli_query($link, $sql1);
		$idusuario = "";

		if ($res1) {
			while ($row = mysqli_fetch_assoc($res1)) {
				$idusuario = $row["idusuario"];
			}

		} else {
			header('Location: index.html');
			exit;
		}

		$sql2 = "SELECT timenome FROM timenome WHERE idtimenome = (SELECT timenome_idtimenome FROM palpite_posicao WHERE usuario_idusuario = '$idusuario' and palpite_posicao = '1' and rodada_idrodada = '$idrodada')";
		$res2 = mysqli_query($link, $sql2);
		$timenome = "";
		if ($res2) {
			while ($row = mysqli_fetch_assoc($res2)) {
				$timenome = $row["timenome"];
			}

		} else {
			header('Location: index.html');
			exit;
		}

		echo "
		<form method=POST action=palpitetime1.php>";
		echo "<br><h3>Que time voce acha que<br>vai ganhar essa rodada?</h3>";
		echo "Time: ";
		echo "<input type=text name=vencedorpalpite>";
		if ($timenome=="") {
			echo "<br><br>";
		} else {
			echo "<p>Seu atual palpite: ".$timenome."</p>";
		}
		echo "<a href=sair.php>Sair</a>";
		echo "<input type=submit value=Palpitar style=margin-left:8.1%>";
		echo "</form>";
	} else {
		echo "
		<form method=POST action=opcaousuario.php>
		<input type=radio name=opcao value=classificacaot> Ver classificacao dos times<br>
		<input type=radio name=opcao value=classificacaop> Ver classificacao dos palpiteiros<br><x>___-</x>nesta rodada<br>
		<input type=radio name=opcao value=classificacaogeral> Ver classificacao dos palpiteiros<br><x>___-</x>em todas as rodadas<br>
		<input type=radio name=opcao value=verpalpite> Ver meus palpites<br>

		<br><button href=opcaousuario.php method=submit>Proximo </button>
		</form>	
		";
		echo "<br><a href=sair.php>Sair</a>";
	}


} else {
	header("Location: index.html");
}

mysqli_close($link);
?>