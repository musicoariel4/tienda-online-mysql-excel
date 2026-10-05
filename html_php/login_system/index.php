<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inicio</title>
</head>
<body>
  <h2>Bienvenido <?= htmlspecialchars($_SESSION["username"]); ?> a la Tienda Online 🎉</h2>
  <p>Elige una sección:</p>
  <ul>
    <li><a href="productos.php">Gestión de Productos</a></li>
    <li><a href="ventas.php">Gestión de Ventas</a></li>
  </ul>
  <a href="logout.php">Cerrar sesión</a>
</body>
</html>