<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
if (!empty($_POST['fecha_ingreso'])) {
    $fecha_ingreso = date('Y-m-d', strtotime($_POST['fecha_ingreso']));
} else {
    $fecha_ingreso = null;
}
$disponible = $_POST['disponible'];

$sql = "INSERT INTO productos (nombre, descripcion, precio, fecha_ingreso, disponible)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssdsi", $nombre, $descripcion, $precio, $fecha_ingreso, $disponible);

if ($stmt->execute()) {
    echo "✅ Producto insertado correctamente. <a href='mostrar_productos.php'>Ver productos</a>";
} else {
    echo "❌ Error al insertar: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
