<?php

require_once "seguranca.php";
require_once "../controller/usuarioController.php";

$usuarioController = new UsuarioController();

// Manejar eliminación
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['excluir'])) {
    $usuarioController->excluir();
}

// Guardar cambios
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['salvar'])) {
    $usuarioController->salvar();
}

// Cargar datos del usuario para edición
$usuario = $usuarioController->abrir();

if (isset($usuario[0])) {
    extract($usuario[0]);
} else {
    $id = 0;
    $nome = '';
    $email = '';
    $senha = '';
}

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

<?php include "menu_esquerdo.php"; ?>

<div class="corpo">
<h3>Registro de usuarios</h3>

<form name="form1" method="post" action="usuario_form.php">
    <input type="hidden" name="id" value="<?= $id ?>" />

    <table class="tabela_comum" cellpadding="4" cellspacing="4">
        <tr>
            <td width="100"> Nombre </td>
            <td><input type="text" name="nome" value="<?= htmlspecialchars($nome) ?>" required /> </td>
        </tr>
        <tr>
            <td width="100"> E-mail</td>
            <td><input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required /></td>
        </tr>
        <tr>
            <td width="100"> Contraseña </td>
            <td><input type="password" name="senha" value="" <?= $id == 0 ? "required" : "" ?> /> </td>
        </tr>
    </table>

    <input type="submit" name="salvar" value="Guardar" class="btn1" />
    <?php if ($id > 0) : ?>
        <input type="submit" name="excluir" value="Eliminar" class="btn1" onclick="return confirm('¿Seguro que quieres eliminar este usuario?')" />
    <?php endif; ?>

    <!-- Botón Cancelar con redirección usando JavaScript -->
    <input type="button" name="cancelar" value="Cancelar" class="btn1" onclick="window.location.href='usuario_list.php';" />

</form>
</div>

</body>
</html>
