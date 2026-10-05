
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Venta con stock</title>
   <link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>
  <h2>Registrar Venta</h2>

  <?php
  $conexion = new mysqli("localhost", "root", "", "tienda_online");
  if ($conexion->connect_error) {
      die("Error de conexión: " . $conexion->connect_error);
  }

  $clientes = $conexion->query("SELECT id, nombre FROM clientes");
  $productos = $conexion->query("SELECT id, nombre, stock FROM productos");
  ?>

  <form action="procesar_venta_stock.php" method="POST">
    <label for="cliente_id">Cliente:</label><br>
    <select name="cliente_id" required>
      <option value="">-- Seleccionar --</option>
      <?php while($c = $clientes->fetch_assoc()): ?>
        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
      <?php endwhile; ?>
    </select><br><br>
    
    <label for="producto_id">Producto:</label><br>
  <select name="producto_id" required>
  <option value="">-- Seleccionar --</option>
  <?php
  //$productos = $conexion->query("SELECT id, nombre, stock FROM productos");
  while($p = $productos->fetch_assoc()): ?>
    <option value="<?= $p['id'] ?>">
      <?= htmlspecialchars($p['nombre']) ?> (Stock: <?= $p['stock'] ?>)
    </option>
  <?php endwhile; ?>
</select><br><br>

    <label for="cantidad">Cantidad Vendida:</label><br>
    <input type="number" name="cantidad" min="1" required><br><br>
    
    <label for="fecha">Fecha de Venta:</label>
    <input type="date" name="fecha" required><br><br>


    <input type="submit" value="Registrar Venta">
  </form>

  <?php $conexion->close(); ?>
</body>
</html>
