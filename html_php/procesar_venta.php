<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente_id = $_POST['cliente_id'];
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];
 

  
$sql = "SELECT precio FROM productos WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $producto_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($fila = $resultado->fetch_assoc()) {
    $precioProducto = $fila['precio']; // ← aquí se guarda el precio
    echo "El precio del producto es: $" . $precioProducto*$cantidad;
} else {
    echo "Producto no encontrado.";
}
    $total = $precioProducto*$cantidad;
    $fecha = $_POST['fecha'];

    $sql = "INSERT INTO ventas (cliente_id, producto_id, cantidad, total, fecha)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iiids", $cliente_id, $producto_id, $cantidad, $total, $fecha);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>✅ Venta registrada exitosamente.</p>";
    } else {
        echo "<p style='color:red;'>❌ Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
} else {
    echo "<p>No se recibieron datos por POST.</p>";
}

$conexion->close();
?>
