<?php
session_start();
require 'db_connection.php'; // Archivo de conexión a la base de datos

header('Content-Type: application/json'); // Asegura que la respuesta sea JSON

// Verificar si el método es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar que el cliente esté autenticado
    if (!isset($_SESSION['id_cliente'])) {
        echo json_encode(["success" => false, "message" => "Error: ID Cliente no encontrado en la sesión"]);
        exit;
    }

    // Obtener parámetros enviados por POST
    $id_cliente = intval($_SESSION['id_cliente']);
    $producto_id = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0;
    $nombre_producto = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '';
    $cantidad = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 0;
    $precio = isset($_POST['precio']) ? floatval($_POST['precio']) : 0.0;
    $categoria = isset($_POST['categoria']) ? htmlspecialchars($_POST['categoria']) : '';

    // Validar los parámetros
    if ($id_cliente > 0 && $producto_id > 0 && $cantidad > 0 && $precio > 0 && !empty($nombre_producto) && !empty($categoria)) {
        try {
            // Preparar la consulta SQL para insertar en la tabla pedidos
            $stmt = $conn->prepare("
                INSERT INTO pedidos (id_cliente, producto_id, nombre_producto, cantidad, precio, categoria)
                VALUES (:id_cliente, :producto_id, :nombre_producto, :cantidad, :precio, :categoria)
            ");

            // Asignar los parámetros
            $stmt->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
            $stmt->bindParam(':producto_id', $producto_id, PDO::PARAM_INT);
            $stmt->bindParam(':nombre_producto', $nombre_producto, PDO::PARAM_STR);
            $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmt->bindParam(':precio', $precio, PDO::PARAM_STR);
            $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);

            // Ejecutar la consulta
            $stmt->execute();

            echo json_encode(["success" => true, "message" => "Pedido guardado correctamente"]);
        } catch (PDOException $e) {
            echo json_encode(["success" => false, "message" => "Error al guardar el pedido: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Datos inválidos o incompletos"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido"]);
}
?>
