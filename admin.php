<?php

echo "<style type=text/css>
body{
	background-color: #7CFC00;
}
</style>";

echo "<br><h2>O que deseja executar?</h2>";
echo "
<form method=POST action=administrador.php><br>
<input type=radio name=opcao value=time> Ver times<br>
<input type=radio name=opcao value=programadas> Ver partidas<br>
<input type=radio name=opcao value=cadastro> Cadastrar times<br>
<input type=radio name=opcao value=partida> Programar partidas<br>
<input type=radio name=opcao value=placar> Definir placares<br>
<input type=radio name=opcao value=avancar> Avançar de rodada<br>
<input type=radio name=opcao value=parar> Parar ação de rodada<br>
<input type=radio name=opcao value=devolver> Devolver ação de rodada<br><br>

<button href=administrador.php method=submit>Proximo </button>
</form>	
";
echo "<br><a href=index.html>Sair</a>";

?>