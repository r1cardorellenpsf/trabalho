<?php

echo "<style type=text/css>
body{
	background-color: #7CFC00;
}
</style>";

echo "<br><h3>Administrador</h3>";
echo "<form method=post action=readadmin.php>";
echo "<br>
Login:
<input type=text name=loginadm>
<br><br>
Senha:
<input type=password name=senhaadm>
<br><br>";
echo "<input type =submit value=Entrar style=margin-left:10.7%>";

echo "</form>";



?>

