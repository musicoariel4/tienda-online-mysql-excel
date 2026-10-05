<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "tienda_online");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Verificamos si ya seleccionaron un producto para editar
$id_producto = isset($_POST['id_producto']) ? (int)$_POST['id_producto'] : 0;
$producto = null;

// Si hay un ID seleccionado, buscamos sus datos y su precio vigente más reciente
if ($id_producto > 0) {
    $sql = "SELECT 
                p.id, 
                p.nombre, 
                p.descripcion, 
                p.fecha_ingreso, 
                p.stock, 
                p.disponible,
                pr.precio AS precio_actual
            FROM productos p
            LEFT JOIN precio pr ON p.id = pr.producto_id
               AND pr.fecha_inicio = (
                   SELECT MAX(pr2.fecha_inicio)
                   FROM precio pr2
                   WHERE pr2.producto_id = p.id
                     AND pr2.fecha_inicio <= CURDATE()
               )
            WHERE p.id = ?";
            
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $producto = $resultado->fetch_assoc();
    $stmt->close();
}

// Consulta para listar productos en el desplegable
$resultado = $conexion->query("SELECT id, nombre FROM productos ORDER BY nombre ASC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>
 <div class="container">
    <h2>Seleccionar Producto para Editar</h2>
    <form method="post">
        <label>Producto:</label><br>
        <select name="id_producto" required>
            <option value="">-- Selecciona --</option>
            <?php while ($row = $resultado->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>" <?= ($id_producto == $row['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($row['nombre']) ?> (ID: <?= $row['id'] ?>)
                </option>
            <?php endwhile; ?>
        </select><br><br>
        <input type="submit" value="Cargar Datos">
    </form>

    <?php if ($producto): ?>
        <hr>
        <h2>Editar Datos del Producto #<?= $producto['id'] ?></h2>
        <form method="post" action="update_producto.php">
            <input type="hidden" name="id" value="<?= $producto['id'] ?>">

            <label>Nombre:</label><br>
            <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required><br><br>

            <label>Descripción:</label><br>
            <textarea name="descripcion" required><?= htmlspecialchars($producto['descripcion']) ?></textarea><br><br>

            <label>Precio:</label><br>
            <input type="number" step="0.01" min="0" name="precio" value="<?= $producto['precio_actual'] ?? 0 ?>" required><br><br>

            <label>Stock:</label><br>
            <input type="number" min="0" name="stock" value="<?= $producto['stock'] ?>" required><br><br>

            <label>Fecha de Ingreso:</label><br>
            <input type="date" name="fecha_ingreso" value="<?= $producto['fecha_ingreso'] ?>" required><br><br>

            <label>Disponible:</label><br>
            <select name="disponible" required>
                <option value="1" <?= ($producto['disponible']) ? 'selected' : '' ?>>Sí</option>
                <option value="0" <?= (!$producto['disponible']) ? 'selected' : '' ?>>No</option>
            </select><br><br>

            <input type="submit" value="Actualizar Producto">
        </form>
    <?php endif; ?>
 </div>
</body>
</html>
<?php $conexion->close(); ?>