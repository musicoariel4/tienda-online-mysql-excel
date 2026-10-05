<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$resultado = $conexion->query("SELECT * FROM clientes");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Listado de Clientes</title>
  <style>
    table {
      border-collapse: collapse;
      width: 80%;
      margin: 20px auto;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: center;
    }
    th {
      background: #2c3e50;
      color: white;
    }
    a {
      text-decoration: none;
      color: #1abc9c;
    }
  </style>
</head>
<body>
  <h2 style="text-align:center;">👥 Listado de Clientes</h2>
  <table>
    <tr>
      <th>ID</th>
      <th>Nombre</th>
      <th>Email</th>
      <th>Teléfono</th>
    </tr>
    <?php while($fila = $resultado->fetch_assoc()): ?>
    <tr>
      <td><?= $fila['id'] ?></td>
      <td><?= htmlspecialchars($fila['nombre']) ?></td>
      <td><?= htmlspecialchars($fila['email']) ?></td>
      <td><?= $fila['telefono'] ?></td>
    </tr>
    <?php endwhile; ?>
  </table>
  <p style="text-align:center;"><a href="menu_crud_clientes.html">⬅ Volver al Menú</a></p>
</body>
</html>
