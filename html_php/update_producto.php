<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id            = (int)$_POST['id'];
    $nombre        = $_POST['nombre'];
    $descripcion   = $_POST['descripcion'];
    $nuevo_precio  = (float)$_POST['precio'];
    $stock         = (int)$_POST['stock'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $disponible    = (int)$_POST['disponible'];
    $fecha_hoy     = date('Y-m-d');

    $conexion->begin_transaction();

    try {
        // 1. Actualizar los datos principales en la tabla 'productos'
        $sqlProd = "UPDATE productos 
                    SET nombre = ?, descripcion = ?, stock = ?, fecha_ingreso = ?, disponible = ? 
                    WHERE id = ?";
        $stmtProd = $conexion->prepare($sqlProd);
        $stmtProd->bind_param("ssisii", $nombre, $descripcion, $stock, $fecha_ingreso, $disponible, $id);
        $stmtProd->execute();
        $stmtProd->close();

        // 2. Insertar un nuevo precio en la tabla 'precio' con la fecha de hoy como fecha_inicio
        $sqlPrecio = "INSERT INTO precio (producto_id, fecha_inicio, fecha_fin, precio) 
                      VALUES (?, ?, NULL, ?)";
        $stmtPrecio = $conexion->prepare($sqlPrecio);
        $stmtPrecio->bind_param("isd", $id, $fecha_hoy, $nuevo_precio);
        $stmtPrecio->execute();
        $stmtPrecio->close();

        $conexion->commit();

        echo "<p style='color:green;'>✅ Producto y precio actualizados con éxito.</p>";
        echo "<p><a href='mostrar_productos.php'>⬅ Volver al listado de productos</a></p>";

    } catch (Exception $e) {
        $conexion->rollback();
        echo "<p style='color:red;'>❌ Error al actualizar el producto: " . $e->getMessage() . "</p>";
    }

} else {
    echo "No se recibieron datos por POST.";
}

$conexion->close();
?>