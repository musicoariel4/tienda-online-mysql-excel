<<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['id'])) {
    $id = (int)$_POST['id'];

    // 1. Verificar si el producto ya fue vendido (asociado a detalle_pedido)
    $sqlCheck = "SELECT COUNT(*) AS total FROM detalle_pedido WHERE producto_id = ?";
    $stmtCheck = $conexion->prepare($sqlCheck);
    $stmtCheck->bind_param("i", $id);
    $stmtCheck->execute();
    $resCheck = $stmtCheck->get_result()->fetch_assoc();
    $stmtCheck->close();

    if ($resCheck['total'] > 0) {
        die("<div style='margin: 30px; font-family: Arial;'>
                <p style='color:red; font-size: 18px;'>❌ No se puede eliminar el producto porque tiene <strong>{$resCheck['total']}</strong> venta(s) asociada(s).</p>
                <p>💡 <em>Recomendación: En lugar de eliminarlo, edita el producto y cambia su estado 'Disponible' a 'No'.</em></p>
                <a href='eliminar_producto.php'>⬅ Volver a intentar</a> | 
                <a href='mostrar_productos.php'>📋 Ver Productos</a>
             </div>");
    }

    // 2. Transacción SQL para eliminar de 'precio' y luego de 'productos'
    $conexion->begin_transaction();

    try {
        // Borrar el historial de precios asociados
        $stmtPrecio = $conexion->prepare("DELETE FROM precio WHERE producto_id = ?");
        $stmtPrecio->bind_param("i", $id);
        $stmtPrecio->execute();
        $stmtPrecio->close();

        // Borrar el producto
        $stmtProd = $conexion->prepare("DELETE FROM productos WHERE id = ?");
        $stmtProd->bind_param("i", $id);
        $stmtProd->execute();
        $stmtProd->close();

        // Confirmar la transacción
        $conexion->commit();

        echo "<div style='margin: 30px; font-family: Arial;'>
                <p style='color:green; font-size: 18px;'>✅ Producto y su historial de precios eliminados correctamente.</p>
                <a href='mostrar_productos.php'>⬅ Volver al listado de productos</a>
              </div>";

    } catch (Exception $e) {
        // Cancelar cambios en caso de error
        $conexion->rollback();
        echo "<div style='margin: 30px; font-family: Arial;'>
                <p style='color:red;'>❌ Error al eliminar el producto: " . $e->getMessage() . "</p>
                <a href='eliminar_producto.php'>⬅ Volver a intentar</a>
              </div>";
    }

} else {
    echo "❌ Solicitud no válida. No se especificó el ID del producto.";
}

$conexion->close();
?>