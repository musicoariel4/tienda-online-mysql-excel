<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Alerta de Stock</title>
</head>
<body>
  <h2>Productos con Stock Bajo</h2>
  <table border="1" cellpadding="10">
    <tr><th>Producto</th><th>Stock Disponible</th></tr>
    <?php
    $query = $conexion->query("SELECT nombre, stock FROM productos WHERE stock <= 10");
    while($row = $query->fetch_assoc()){
        echo "<tr><td>{$row['nombre']}</td><td>{$row['stock']}</td></tr>";
    }
    ?>
  </table>
</body>
</html>