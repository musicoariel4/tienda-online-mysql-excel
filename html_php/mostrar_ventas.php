<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta ajustada para obtener el precio según la fecha del pedido desde la tabla 'precio'
$sql = "SELECT
    p.id AS pedido, 
    p.fecha, 
    c.nombre AS cliente,
    prod.nombre AS producto,
    d.cantidad, 
    pr.precio AS precio,
    (d.cantidad * pr.precio) AS total
FROM pedidos p
JOIN clientes c ON p.cliente_id = c.id
JOIN detalle_pedido d ON p.id = d.pedido_id
JOIN productos prod ON d.producto_id = prod.id
JOIN precio pr ON d.producto_id = pr.producto_id
   AND pr.fecha_inicio = (
       SELECT MAX(pr2.fecha_inicio)
       FROM precio pr2
       WHERE pr2.producto_id = d.producto_id
         AND pr2.fecha_inicio <= p.fecha
   )
ORDER BY p.fecha DESC";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Listado de Ventas</title>
  <style>
    table {
      border-collapse: collapse;
      width: 90%;
      margin: 20px auto;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: center;
    }
    th {
      background-color: #f4f4f4;
    }
    .btn-delete {
      background: red;
      color: white;
      padding: 5px 10px;
      border: none;
      cursor: pointer;
      border-radius: 4px;
    }
    .btn-edit {
      background: #007bff;
      color: white;
      padding: 5px 10px;
      border: none;
      cursor: pointer;
      border-radius: 4px;
    }
  </style>
</head>
<body>
  <h2 style="text-align:center;">📋 Listado de Ventas</h2>

  <table>
    <tr>
      <th>ID</th>
      <th>Fecha</th>
      <th>Cliente</th>
      <th>Producto</th>
      <th>Cantidad</th>
      <th>Precio Unitario</th>
      <th>Total</th>
      <th>Borrar</th>
      <th>Editar</th>
    </tr>
    <?php while($fila = $resultado->fetch_assoc()): ?>
    <tr>
      <td><?= $fila['pedido'] ?></td>
      <td><?= $fila['fecha'] ?></td>
      <td><?= $fila['cliente'] ?></td>
      <td><?= $fila['producto'] ?></td>
      <td><?= $fila['cantidad'] ?></td>
      <td>$<?= number_format($fila['precio'], 2) ?></td>
      <td>$<?= number_format($fila['total'], 2) ?></td>
      <td>
        <form action="eliminar_venta.php" method="post" onsubmit="return confirm('¿Seguro que deseas eliminar esta venta?');">
          <input type="hidden" name="id" value="<?= $fila['pedido'] ?>">
          <button type="submit" class="btn-delete">🗑️ Eliminar</button>
        </form>
      </td>
      <td>
        <!-- Botón Editar -->
        <form action="editar_venta.php" method="get" style="display:inline;">
          <input type="hidden" name="id" value="<?= $fila['pedido'] ?>">
          <button type="submit" class="btn-edit">✏️ Editar</button>
        </form>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
  <p style="text-align:center;"><a href="menu_crud_ventas.html">⬅ Volver al Menú</a></p>
</body>
</html>