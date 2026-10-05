<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$sql = "SELECT * FROM productos";
$resultado = $conexion->query($sql);

echo "<h2>Listado de productos</h2>";
echo "<table border='1' cellpadding='8'>";
echo "<tr><th>ID</th><th>Nombre</th><th>Descripción</th>
<th>Precio</th><th>Fecha Ingreso</th><th>Stock</th><th>Disponible</th></tr>";

while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $fila['id'] . "</td>";
    echo "<td>" . $fila['nombre'] . "</td>";    
    echo "<td>" . $fila['descripcion'] . "</td>";
    echo "<td>$" . $fila['precio'] . "</td>";
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
