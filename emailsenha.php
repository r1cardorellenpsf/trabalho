<?php

$data_envio = date('d/m/Y');
$hora_envio = date('H:i:s');

$email = $_POST['email'];

$link = mysqli_connect("127.0.0.1", "root", "", "cartola");

if (!$link) {
	header('Location: index.html');
	exit;
}

$sql = "SELECT senha FROM usuario WHERE email LIKE '$email'";

$res = mysqli_query($link, $sql);

$senha = "";

if ($res) {
	while ($row = mysqli_fetch_assoc($res)) {
		$senha = $row["senha"];
	}
	
	$arquivo = "
	<style type='text/css'>
		body {
			margin:0px;
			font-family:Verdane;
			font-size:12px;
			color: #666666;
		}
		a{
			color: #666666;
			text-decoration: none;
		}
		a:hover {
			color: #FF0000;
			text-decoration: none;
		}
	</style>
	<html>
	<table width='510' border='1' cellpadding='1' cellspacing='1' bgcolor='#CCCCCC'>
		<tr>
			<td>

				<tr>
					<td width='320'>E-mail:<b>$email</b></td>
				</tr>
			</td>
		</tr>  
		<tr>
			<td>Este e-mail foi enviado em <b>$data_envio</b> às <b>$hora_envio</b></td>
		</tr>
	</table>
	</html>
	";


	$emailenviar = "rodrigueslimaricardoo@gmail.com";
	$destino = $emailenviar;
	$assunto = "Sua senha é: ".$senha.". Para mudá-la, acesse a sua conta.";

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: <$email>';

	$enviaremail = mail($destino, $assunto, $arquivo, $headers);

	if($enviaremail){
		$mgm = "E-MAIL ENVIADO COM SUCESSO! <br> O link será enviado para o e-mail fornecido no formulário";
		echo " <meta http-equiv='refresh' content='10;URL=contato.php'>";
	} else {
		$mgm = "ERRO AO ENVIAR E-MAIL!";
		echo "";
	}

	exit;
} else {
	header('Location: index.html');
	exit;
}

mysqli_close($link);

?>

