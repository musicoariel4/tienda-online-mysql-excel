<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];

$sql = "INSERT INTO clientes (nombre, direccion, telefono, email)
        VALUES (?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssss", $nombre, $direccion, $telefono, $email);

if ($stmt->execute()) {
    echo "✅ Producto insertado correctamente. <a href='mostrar_productos.php'>Ver productos</a>";
} else {
    echo "❌ Error al insertar: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
