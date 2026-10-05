<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "tienda_online");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// ID del producto a eliminar (puede venir de un formulario)
$id =(int)$_POST['id'];

// Consulta DELETE con parámetros
$sql = "DELETE FROM productos WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Producto eliminado correctamente.";
} else {
    echo "Error al eliminar: posiblemente tiene una venta asignada revisa" ;
}

$stmt->close();
$conexion->close();
?>
