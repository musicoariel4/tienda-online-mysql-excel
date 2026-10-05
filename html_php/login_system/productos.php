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

$sql = "SELECT id, nombre, precio, stock FROM productos ORDER BY id ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Productos</title>
  <style>
    table{border-collapse:collapse;width:100%}
    th,td{border:1px solid #ccc;padding:8px;text-align:left}
    th{background:#f0f0f0}
  </style>
</head>
<body>
  <h2>Listado de Productos</h2>
  <p>Accediste como: <?= htmlspecialchars($_SESSION["username"]); ?></p>

  <?php if ($result && $result->num_rows > 0): ?>
    <table>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Stock</th>
      </tr>
      <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row["id"] ?></td>
          <td><?= htmlspecialchars($row["nombre"]) ?></td>
          <td><?= $row["precio"] ?></td>
          <td><?= $row["stock"] ?></td>
        </tr>
      <?php endwhile; ?>
    </table>
  <?php else: ?>
    <p>No hay productos registrados.</p>
  <?php endif; ?>

  <br>
  <a href="index.php">Volver al inicio</a> | <a href="logout.php">Cerrar sesión</a>
</body>
</html>