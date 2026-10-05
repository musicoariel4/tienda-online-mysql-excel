<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "tienda_online");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Verificamos si ya seleccionaron un producto para editar
$id_producto = isset($_POST['id_producto']) ? (int)$_POST['id_producto'] : 0;
$producto = null;

// Si hay un ID seleccionado, buscamos sus datos
if ($id_producto > 0) {
    $stmt = $conexion->prepare("SELECT * FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $producto = $resultado->fetch_assoc();
    $stmt->close();
}

// Consulta para listar productos
$resultado = $conexion->query("SELECT id, nombre FROM productos");
?>
<!DOCTYPE html>
<html>
<head>
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
        </select>
      <!--  <button type="submit">Cargar Datos</button> -->
         <input type="submit" value="Cargar Datos">
    </form>

    <?php if ($producto): ?>
        <h2>Editar Datos del Producto</h2>
        <form method="post" action="update_producto.php">
            <input type="hidden" name="id" value="<?= $producto['id'] ?>">

            <label>Nombre:</label><br>
            <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required><br><br>

            <label>Descripción:</label><br>
            <textarea name="descripcion" required><?= htmlspecialchars($producto['descripcion']) ?></textarea><br><br>

            <label>Precio:</label><br>
            <input type="number" step="0.01" name="precio" value="<?= $producto['precio'] ?>" required><br><br>

            <label>Fecha de Ingreso:</label><br>
            <input type="date" name="fecha_ingreso" value="<?= $producto['fecha_ingreso'] ?>" required><br><br>

            <label>Disponible:</label><br>
            <select name="disponible" required>
                <option value="1" <?= ($producto['disponible']) ? 'selected' : '' ?>>Sí</option>
                <option value="0" <?= (!$producto['disponible']) ? 'selected' : '' ?>>No</option>
            </select><br><br>

      <!--      <button type="submit">Actualizar Producto</button> -->
             <input type="submit" value="Actualizar Producto">
        </form>
    <?php endif; ?>
 </div>
</body>
</html>
<?php $conexion->close(); ?>
