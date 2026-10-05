<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "tienda_online");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener la lista de productos ordenados por nombre
$resultado = $conexion->query("SELECT id, nombre FROM productos ORDER BY nombre ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Producto</title>
    <link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>
    <div class="container">
        <h2>🗑️ Eliminar Producto</h2>
        
        <form action="delete_producto.php" method="post" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto? Se borrará también su historial de precios.');">
            <label for="id">Selecciona el Producto a Eliminar:</label><br><br>
            
            <select name="id" id="id" required style="width: 100%; padding: 8px;">
                <option value="">-- Selecciona un producto --</option>
                <?php while ($producto = $resultado->fetch_assoc()): ?>
                    <option value="<?= $producto['id'] ?>">
                        <?= htmlspecialchars($producto['nombre']) ?> (ID: <?= $producto['id'] ?>)
                    </option>
                <?php endwhile; ?>
            </select><br><br>

            <input type="submit" value="Eliminar Producto" style="background-color: #d9534f; color: white; border: none; padding: 10px; cursor: pointer; border-radius: 4px;">
        </form>
        
        <p><a href="mostrar_productos.php">⬅ Volver al listado de productos</a></p>
    </div>
</body>
</html>
<?php $conexion->close(); ?>
