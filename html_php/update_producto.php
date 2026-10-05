<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "tienda_online");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recibir los datos del formulario (ya validados en el formulario)
$id = (int)$_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = (float)$_POST['precio'];
$fecha_ingreso = $_POST['fecha_ingreso'];
$disponible = (int)$_POST['disponible'];

// Actualizar el producto
$sql = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, fecha_ingreso = ?, disponible = ? WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssdssi", $nombre, $descripcion, $precio, $fecha_ingreso, $disponible, $id);

if ($stmt->execute()) {
    echo "<h2>Producto actualizado correctamente.</h2>";
} else {
    echo "<h2>Error al actualizar el producto: " . $stmt->error . "</h2>";
}

$stmt->close();
$conexion->close();
?>

<!-- Botón para volver al formulario -->
<a href="editar_producto.php">Volver al formulario de edición</a>
