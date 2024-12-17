<?php
// Asegúrate de que la conexión a la base de datos esté establecida correctamente
require 'db_connection.php';

// Obtener el parámetro `locality_id` enviado en la solicitud
if (isset($_GET['locality_id'])) {
    $locality_id = $_GET['locality_id'];

    // Consultar las calles según la localidad
    $query = "SELECT id, nombre_calle, numero FROM calles WHERE localidad_id = :locality_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':locality_id', $locality_id, PDO::PARAM_INT);
    $stmt->execute();
    $streets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retornar las calles en formato JSON
    echo json_encode($streets);
} else {
    echo json_encode([]);
}
?>
