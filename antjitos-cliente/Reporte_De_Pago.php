<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reporte de Pago</title>
  <style>
    /* Estilos generales */
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f5f5f5;
      margin: 0;
      padding: 20px;
      color: #333;
    }

    .container {
      max-width: 600px;
      margin: auto;
      background-color: #ffffff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    h1 {
      text-align: center;
      color: #e63946; /* Rojo oscuro */
      margin-bottom: 20px;
    }

    label {
      font-weight: bold;
      margin-top: 10px;
      display: block;
    }

    input[type="text"],
    input[type="datetime-local"],
    input[type="file"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
      box-sizing: border-box;
    }

    input[type="file"] {
      padding: 5px;
    }

    /* Botón estilizado */
    button[type="submit"] {
      background-color: #e63946; /* Rojo */
      color: white;
      padding: 15px 20px;
      border: none;
      border-radius: 5px;
      font-size: 18px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
      width: 100%;
    }

    button[type="submit"]:hover {
      background-color: #d62839; /* Rojo más oscuro */
      transform: scale(1.05);
    }

    button[type="submit"]:active {
      transform: scale(0.98);
      background-color: #c72535; /* Rojo aún más oscuro */
    }

    /* Estilo de texto en pequeño */
    small {
      display: block;
      text-align: center;
      color: #777;
      margin-top: 15px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Reporte de Pago</h1>
    <form action="index.php" method="POST" enctype="multipart/form-data">
      <!-- Campo oculto para enviar el id_pedido -->
      <input type="hidden" name="id_pedido" value="<?php echo $id_pedido; ?>">

      <label for="reference">Número de Referencia</label>
      <input type="text" id="reference" name="reference" placeholder="Ingrese el código único de la transacción" required>

      <label for="date-time">Fecha y Hora</label>
      <input type="datetime-local" id="date-time" name="date-time" required>

      <label for="proof">Comprobante de Pago</label>
      <input type="file" id="proof" name="proof" accept="image/*" required>

      <button type="submit">Generar Reporte</button>
      
    </form>
    <small>Por favor, asegúrese de que todos los datos sean correctos antes de enviar.</small>
  </div>
</body>
</html>
