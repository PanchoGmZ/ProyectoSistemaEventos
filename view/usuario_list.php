<?php

require_once "seguranca.php";
require "../controller/usuarioController.php";

$usuarioController = new UsuarioController();
$lista = $usuarioController->listarcontroller();

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="js/jquery.js"></script>
    <script src="js/jquery.datetimepicker.full.js"></script>
    <script src="js/dateformat.js"></script>
    <link rel="stylesheet" type="text/css" href="css/estilo.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css">
    <script src="js/lib.js"></script>
</head>
<title>Registro de usuarios</title>
<body>

<!-- form -->
<div class="form"></div>

<!-- menu esquerdo -->
<?php include "menu_esquerdo.php"; ?>

<!-- conteudo -->
<div class="corpo">

<h3> Registro de usuarios </h3>

<input type="button" name="novo" value="Agregar Usuario" class="btn1" onclick="abre('usuario_form.php')" />

<table class="lista_comum" cellpadding="4" cellspacing="4">
    <thead>
        <tr>
            <th> id </th>
            <th> Nombre </th>
            <th> E-mail </th>
            <th> Acciones </th>
        </tr>
    </thead>
    <tbody>
        <?= $lista ?>
    </tbody>
</table>

</div>

</body>
</html>
