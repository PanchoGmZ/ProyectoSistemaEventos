<?php

require_once "config.php";
require_once "../controller/usuarioController.php";

$usuarioController = new UsuarioController();
$errormsg = $usuarioController->autenticarController();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="css/estilo.css"/>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema de Reservas de Salas de Conferencias y Eventos</title>

<style type="text/css">
body,td,th {
	font-family: "Open Sans", sans-serif;
}
</style>
</head>

<body>
<form action="login.php" method="post"  name="Formulario">

<div id="content">

<div id="esquerdo">
<img src="img/loginreservas.jpg" width="478" height="320" />
    <div id="aviso">
    
    <h3>Haga click, consulte y reserve!</h3> 
    La forma mas practica y simple de reservar salas de confererncias y eventos.</div>

</div>

<div id="direito">

<br />
<br />
<img src="img/logoconference.png" alt="Sistema de Reservas de Salas de Aula" title="Sistema de Reservas de Salas de Aula" width="220" height="120" />
<br />
<br />
version <strong>1.0</strong>&nbsp;<br />
<span style="color:#900"><?php echo $errormsg; ?></span><br />

<input type="text" name="email" id="email" placeholder="E-mail"  />
<br />
<br />

<input type="password" name="senha" id="senha" placeholder="Contraseña" />
<br />
<br />


<input type="submit" name="entrar" value="Ingresar" class="btn1" />

</div>
</div>

<div id="rodape">


</div>

</form>
</body>
</html>