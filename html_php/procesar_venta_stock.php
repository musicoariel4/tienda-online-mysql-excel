<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
// Capturar datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente_id = $_POST['cliente_id'];
    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];
    
 
// 1. Consultar stock actual del producto
$resultado = $conexion->query("SELECT stock FROM productos WHERE id = $producto_id");
$producto = $resultado->fetch_assoc();
// 2. Validar stock suficiente
$stock_actual = $producto['stock'];
if ($producto['stock'] == 0) {
    die("❌ Error: No hay stock disponible.");
}
if ($cantidad > $producto['stock']) {
    die("❌ Error: La cantidad solicitada es mayor al stock disponible.");
} 
  
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
    $sqlpedido= "INSERT INTO pedidos (cliente_id, fecha) VALUES (?, ?)";
    $stmtpedido = $conexion->prepare($sqlpedido);
    $stmtpedido->bind_param("is", $cliente_id, $fecha);
    $stmtpedido->execute();

   # 3. Obtener el ID del pedido recién insertado
    $pedido_id = $conexion->insert_id;
   
    # 4. Insertar en detalle_pedido
    $sqldetalle = "INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad) 
    VALUES (?, ?, ?)";
    $stmtdetalle = $conexion->prepare($sqldetalle);
    $stmtdetalle->bind_param("iii", $pedido_id, $producto_id, $cantidad);



    if ($stmtdetalle->execute()) {
        echo "<p style='color:green;'>✅ Venta registrada exitosamente.</p>";
    } else {
        echo "<p style='color:red;'>❌ Error: " . $stmtdetalle->error . "</p>";
    }

    $stmtdetalle->close();
    // 4. Actualizar stock del producto

$nuevo_stock = $stock_actual - $cantidad;
$conexion->query("UPDATE productos SET stock = $nuevo_stock WHERE id = $producto_id");

echo "✅ Venta registrada con éxito. Stock actualizado: $nuevo_stock unidades.";

} else {
    echo "<p>No se recibieron datos por POST.</p>";
}

$conexion->close();
?>
