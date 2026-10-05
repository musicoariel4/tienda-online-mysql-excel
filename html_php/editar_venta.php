<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$id = $_GET['id'];

// Obtener datos de la venta
$sql = "SELECT p.id, p.cliente_id, p.fecha, d.producto_id, d.cantidad
        FROM pedidos p
        JOIN detalle_pedido d ON p.id = d.pedido_id
        WHERE p.id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$venta = $resultado->fetch_assoc();

// Obtener lista de clientes y productos
$clientes = $conexion->query("SELECT id, nombre FROM clientes");
$productos = $conexion->query("SELECT id, nombre FROM productos");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Venta</title>
</head>
<body>
  <h2>✏️ Editar Venta</h2>
  <form action="update_venta2.php" method="post">
    <input type="hidden" name="id" value="<?= $venta['id'] ?>">

    <label>Cliente:</label><br>
    <select name="cliente_id" required>
      <?php while($c = $clientes->fetch_assoc()): ?>
        <option value="<?= $c['id'] ?>" <?= $c['id']==$venta['cliente_id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($c['nombre']) ?>
        </option>
      <?php endwhile; ?>
    </select><br><br>

    <label>Producto:</label><br>
    <select name="producto_id" required>
      <?php while($p = $productos->fetch_assoc()): ?>
        <option value="<?= $p['id'] ?>" <?= $p['id']==$venta['producto_id'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($p['nombre']) ?>
        </option>
      <?php endwhile; ?>
    </select><br><br>

    <label>Cantidad:</label><br>
    <input type="number" name="cantidad" value="<?= $venta['cantidad'] ?>" min="1" required><br><br>

   

    <button type="submit">💾 Actualizar</button>
  </form>
</body>
</html>
