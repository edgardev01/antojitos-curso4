<?php
session_start();
require 'db_connection.php'; // Conexión a la base de datos

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_cliente'])) {
    die("Error: Debe iniciar sesión para ver sus pedidos.");
}

$id_cliente = $_SESSION['id_cliente'];

// Consultar los pedidos del usuario
try {
    $stmt = $conn->prepare("SELECT * FROM pedidos WHERE id_cliente = :id_cliente");
    $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
    $stmt->execute();
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calcular el total
    $total = 0;
    foreach ($pedidos as $pedido) {
        $total += $pedido['cantidad'] * $pedido['precio'];
    }
} catch (PDOException $e) {
    die("Error al obtener los pedidos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar Pedido</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .payment-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .payment-container h2 {
            color: red;
            margin-bottom: 20px;
        }
        .total-amount {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        .input-field {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        .next-button {
            background-color: red;
            color: white;
            padding: 15px 20px;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .next-button:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>

<div class="payment-container">
    <h2>Total a Pagar</h2>
    <div class="total-amount" id="total_pago"><?php echo number_format($total, 2); ?> MXN</div>

    <!-- Formulario para ingresar los detalles del banco y cuenta -->
    <form action="confirmar_pago.php" method="POST">
        <label for="bank_name">Nombre del Banco:</label>
        <input type="text" name="bank_name" id="bank_name" class="input-field" placeholder="Ingresa el nombre del banco" required>

        <label for="account_number">Número de Cuenta:</label>
        <input type="text" name="account_number" id="account_number" class="input-field" placeholder="Ingresa el número de cuenta" required>

        <!-- Campo oculto para enviar el total -->
        <input type="hidden" name="total" value="<?php echo $total; ?>">

        <!-- Botón para realizar el pago -->
        <button class="next-button" onclick="redirectToReporteDePago()">Siguiente</button>
    </form>
</div>


<script>
    // Función para redirigir a la página de Reporte_De_Pago.html
    function redirectToReporteDePago() {
        window.location.href = 'Reporte_De_Pago.php';
    }
</script>

</body>
</html>
