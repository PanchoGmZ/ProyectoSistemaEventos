<?php
require_once "seguranca.php";

// Conectar a la base de datos (MODIFICA ESTOS DATOS)
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "sgreserva";

try {
    $conexao = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para obtener los pagos
    $sql = "SELECT id, usuario, reserva, monto, metodo_pago, estado FROM pagamento";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $pagos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Pagos</title>

    <script src="js/jquery.js"></script>
    <script src="js/jquery.datetimepicker.full.js"></script>
    <script src="js/dateformat.js"></script>

    <link rel="stylesheet" type="text/css" href="css/estilo.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css">
    <script src="js/lib.js"></script>

    <style>
        .pendiente { color: orange; font-weight: bold; }
        .pagado { color: green; font-weight: bold; }
        .cancelado { color: red; font-weight: bold; }
    </style>
</head>
<body>

<!-- menu esquerdo -->
<?php include "menu_esquerdo.php"; ?>

<!-- contenido -->
<div class="corpo">
    <h3>Gestión de Pagos</h3>

    <input type="button" name="nuevo" value="Registrar Pago" class="btn1" onclick="abre('pagamento_form.php')" />

    <table class="lista_comum" cellpadding="4" cellspacing="4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Reserva</th>
                <th>Monto</th>
                <th>Método de Pago</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pagos as $pago): ?>
                <tr>
                    <td><?= $pago['id'] ?></td>
                    <td><?= htmlspecialchars($pago['usuario']) ?></td>
                    <td><?= htmlspecialchars($pago['reserva']) ?></td>
                    <td>$<?= number_format($pago['monto'], 2) ?></td>
                    <td><?= ucfirst(htmlspecialchars($pago['metodo_pago'])) ?></td>
                    <td><span class="<?= strtolower($pago['estado']) ?>"><?= ucfirst(htmlspecialchars($pago['estado'])) ?></span></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
