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

// Confirmar el pago (cambiar el estado)
if (isset($_GET['confirmar_id'])) {
    $id_pago = $_GET['confirmar_id'];
    try {
        $updateSql = "UPDATE pagamento SET estado = 'Confirmado' WHERE id = :id";
        $updateStmt = $conexao->prepare($updateSql);
        $updateStmt->bindParam(':id', $id_pago);
        $updateStmt->execute();
        header("Location: pagos.php");  // Redirigir después de confirmar
    } catch (PDOException $e) {
        die("Error al actualizar el estado: " . $e->getMessage());
    }
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .pendiente { color: orange; font-weight: bold; }
        .pagado { color: green; font-weight: bold; }
        .cancelado { color: red; font-weight: bold; }
        .confirmado { color: green; font-weight: bold; }
        .btn-confirmar {
            background-color: green;
            color: white;
            border: none;
            padding: 5px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-confirmar:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>

<!-- menu esquerdo -->
<?php include "menu_esquerdo.php"; ?>

<!-- contenido -->
<div class="corpo">
    <h3>Gestión de Pagos</h3>


    <table class="lista_comum" cellpadding="4" cellspacing="4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Reserva</th>
                <th>Monto</th>
                <th>Método de Pago</th>
                <th>Estado</th>
                <th>Acciones</th>
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
                    <td>
    <!-- Cambiar color dependiendo del estado -->
    <span class="<?= strtolower($pago['estado']) ?>">
        <?= htmlspecialchars($pago['estado']) ?>
    </span>
</td>

                    <td>
                        <?php if ($pago['estado'] == 'Pendiente'): ?>
                            <!-- Botón Confirmar -->
                            <a href="?confirmar_id=<?= $pago['id'] ?>" class="btn-confirmar">Confirmar</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
