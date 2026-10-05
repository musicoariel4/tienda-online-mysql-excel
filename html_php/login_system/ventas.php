<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.html");
    exit;
}

$DB_HOST = "localhost";
$DB_NAME = "tienda_online";
$DB_USER = $_SESSION["username"];
$DB_PASS = $_SESSION["password"];

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$sql = "SELECT v.id, c.nombre AS cliente, p.nombre AS producto, v.cantidad, v.total, v.fecha
        FROM ventas v
        LEFT JOIN clientes c ON v.cliente_id = c.id
        LEFT JOIN productos p ON v.producto_id = p.id
        ORDER BY v.fecha DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ventas</title>
  <style>
    table{border-collapse:collapse;width:100%}
    th,td{border:1px solid #ccc;padding:8px;text-align:left}
    th{background:#f0f0f0}
  </style>
</head>
<body>
  <h2>Listado de Ventas</h2>
  <p>Accediste como: <?= htmlspecialchars($_SESSION["username"]); ?></p>

  <?php if ($result && $result->num_rows > 0): ?>
    <table>
      <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Total</th>
        <th>Fecha</th>
      </tr>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row["id"] ?></td>
          <td><?= htmlspecialchars($row["cliente"]) ?></td>
          <td><?= htmlspecialchars($row["producto"]) ?></td>
          <td><?= $row["cantidad"] ?></td>
          <td><?= $row["total"] ?></td>
          <td><?= $row["fecha"] ?></td>
        </tr>
      <?php endwhile; ?>
    </table>
  <?php else: ?>
    <p>No hay ventas registradas.</p>
  <?php endif; ?>

  <br>
  <a href="index.php">Volver al inicio</a> | <a href="logout.php">Cerrar sesión</a>
</body>
</html>