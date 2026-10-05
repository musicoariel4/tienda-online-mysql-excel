<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta con JOIN para traer nombre del cliente y nombre del producto
$sql = "SELECT
    p.id AS pedido, p.fecha, c.nombre AS cliente,
    prod.nombre AS producto,
    d.cantidad, prod.precio,
    d.cantidad * prod.precio AS total
FROM pedidos p
JOIN clientes c ON p.cliente_id = c.id
JOIN detalle_pedido d ON p.id = d.pedido_id
JOIN productos prod ON d.producto_id = prod.id
ORDER BY p.fecha";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Listado de Ventas</title>
  <style>
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #999; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
  </style>
</head>
<body>
  <h2>Listado de Ventas</h2>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Fecha</th>
        <th>Cliente</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th>Total</th>
        </tr>
    </thead>
    <tbody>
      <?php while ($fila = $resultado->fetch_assoc()) { ?>
        <tr>
          <td><?= $fila['pedido'] ?></td>
             <td><?= $fila['fecha'] ?></td>
          <td><?= $fila['cliente'] ?></td>
          <td><?= $fila['producto'] ?></td>
          <td><?= $fila['cantidad'] ?></td>
          <td>$<?= number_format($fila['precio'], 2) ?></td>
          <td>$<?= number_format($fila['total'], 2) ?></td>
        
        </tr>
      <?php } ?>
    </tbody>
  </table>
   <p style="text-align:center;"><a href="menu_crud_ventas.html">⬅ Volver al Menú</a></p>
</body>
</html>

<?php $conexion->close(); ?>
