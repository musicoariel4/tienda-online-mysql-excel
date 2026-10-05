<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta SQL para obtener cada producto con su precio más reciente vigente a hoy
$sql = "SELECT 
            p.id, 
            p.nombre, 
            p.descripcion, 
            p.fecha_ingreso, 
            p.stock, 
            p.disponible,
            pr.precio AS precio_actual
        FROM productos p
        LEFT JOIN precio pr ON p.id = pr.producto_id
           AND pr.fecha_inicio = (
               SELECT MAX(pr2.fecha_inicio)
               FROM precio pr2
               WHERE pr2.producto_id = p.id
                 AND pr2.fecha_inicio <= CURDATE()
           )
        ORDER BY p.id ASC";

$resultado = $conexion->query($sql);

echo "<h2>Listado de productos</h2>";
echo "<table border='1' cellpadding='8' style='border-collapse: collapse; width: 90%; margin: 20px auto; text-align: center;'>";
echo "<tr style='background-color: #f4f4f4;'>
        <th>ID</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Precio Actual</th>
        <th>Fecha Ingreso</th>
        <th>Stock</th>
        <th>Disponible</th>
      </tr>";

while ($fila = $resultado->fetch_assoc()) {
    // Si un producto aún no tiene precio asignado en la tabla 'precio', muestra 'N/A'
    $precioFormateado = isset($fila['precio_actual']) 
        ? "$" . number_format($fila['precio_actual'], 2) 
        : "Sin precio";

    echo "<tr>";
    echo "<td>" . $fila['id'] . "</td>";
    echo "<td>" . htmlspecialchars($fila['nombre']) . "</td>";    
    echo "<td>" . htmlspecialchars($fila['descripcion']) . "</td>";
    echo "<td>" . $precioFormateado . "</td>";
    echo "<td>" . $fila['fecha_ingreso'] . "</td>";
    echo "<td>" . $fila['stock'] . "</td>";
    echo "<td>" . ($fila['disponible'] ? "Sí" : "No") . "</td>";
    echo "</tr>";
}
echo "</table>";

$conexion->close();
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>

</body>
</html>
