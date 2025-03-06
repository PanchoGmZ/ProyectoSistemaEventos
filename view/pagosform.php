<?php
// Conectar a la base de datos
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "sgreserva";

try {
    $conexao = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Procesar el formulario cuando se envía
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = htmlspecialchars($_POST["nombre"]);
        $reserva = htmlspecialchars($_POST["reserva"]);
        $monto = floatval($_POST["monto"]);
        $metodo = $_POST["metodo"];
        $estado = 'Pendiente';  // Estado inicial del pago

        // Insertar el pago en la base de datos
        if ($monto < 1) {
            $mensaje = "<div class='alert alert-danger'>Error: El monto debe ser mayor a 0.</div>";
        } else {
            $sql = "INSERT INTO pagamento (usuario, reserva, monto, metodo_pago, estado) 
                    VALUES (:usuario, :reserva, :monto, :metodo_pago, :estado)";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':usuario', $nombre);
            $stmt->bindParam(':reserva', $reserva);
            $stmt->bindParam(':monto', $monto);
            $stmt->bindParam(':metodo_pago', $metodo);
            $stmt->bindParam(':estado', $estado);

            if ($stmt->execute()) {
                // Si el pago se guarda correctamente, mostrar mensaje de éxito
                echo "<script>
                        setTimeout(function() {
                            alert('¡Listo!');
                            window.location.href = 'index.php';
                        }, 2000);
                    </script>";
            } else {
                $mensaje = "<div class='alert alert-danger'>Hubo un error al registrar el pago.</div>";
            }
        }
    }
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f7f6;
        }
        .container {
            max-width: 400px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        h2 {
            color: #333;
        }
        .btn-primary {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }
        .btn-primary:hover {
            background-color: #45a049;
            border-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Formulario de Pago</h2>
    
    <?php echo isset($mensaje) ? $mensaje : ''; ?>

    <form action="" method="POST" class="mt-3">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del titular</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>

        <div class="mb-3">
            <label for="reserva" class="form-label">Código de Reserva</label>
            <input type="text" class="form-control" id="reserva" name="reserva" required>
        </div>

        <div class="mb-3">
            <label for="monto" class="form-label">Monto a pagar ($)</label>
            <input type="number" class="form-control" id="monto" name="monto" step="0.01" min="1" required>
        </div>

        <div class="mb-3">
            <label for="metodo" class="form-label">Método de pago</label>
            <select class="form-select" id="metodo" name="metodo" required>
                <option value="Efectivo">Efectivo</option>
                <option value="Tarjeta">Tarjeta</option>
                <option value="Transferencia">Transferencia</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Realizar Pago</button>
    </form>
</div>

</body>
</html>
