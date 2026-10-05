<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Capturar datos del formulario
$nombre      = $_POST['nombre'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$precio      = $_POST['precio'] ?? 0;
// Capturar el nuevo campo stock
$stock = isset($_POST['stock']) ? (int)$_POST['stock'] : 0;
$disponible  = $_POST['disponible'] ?? 1;

if (!empty($_POST['fecha_ingreso'])) {
    $fecha_ingreso = date('Y-m-d', strtotime($_POST['fecha_ingreso']));
} else {
    $fecha_ingreso = date('Y-m-d'); // Si viene vacío, se asigna la fecha actual
}

// Iniciamos la transacción para asegurar que ambas inserciones se completen correctamente
$conexion->begin_transaction();

try {
    // 1. Insertar en la tabla 'productos' (sin el campo precio)
   // Inserción en la tabla productos incluyendo el stock
$sqlProducto = "INSERT INTO productos (nombre, descripcion, fecha_ingreso, disponible, stock) VALUES (?, ?, ?, ?, ?)";
$stmtProducto = $conexion->prepare($sqlProducto);
$stmtProducto->bind_param("sssii", $nombre, $descripcion, $fecha_ingreso, $disponible, $stock);
    $stmtProducto->execute();

    // 2. Obtener el ID del producto recién insertado
    $producto_id = $conexion->insert_id;
    $stmtProducto->close();

    // 3. Insertar el precio inicial en la tabla 'precio'
    $sqlPrecio = "INSERT INTO precio (producto_id, fecha_inicio, fecha_fin, precio) VALUES (?, ?, NULL, ?)";
    $stmtPrecio = $conexion->prepare($sqlPrecio);
    $stmtPrecio->bind_param("isd", $producto_id, $fecha_ingreso, $precio);
    $stmtPrecio->execute();
    $stmtPrecio->close();

    // Confirmar los cambios en la base de datos
    $conexion->commit();

    echo "✅ Producto y precio registrados correctamente. <a href='mostrar_productos.php'>Ver productos</a>";

} catch (Exception $e) {
    // Revertir en caso de algún error
    $conexion->rollback();
    echo "❌ Error al insertar el producto: " . $e->getMessage();
}

$conexion->close();
?>