<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - Tienda Online</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      text-align: center;
    }
    h1 { margin: 20px; }
    .menu {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 20px;
    }
    .menu a {
      display: block;
      padding: 15px 25px;
      background: #4CAF50;
      color: white;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
    }
    .menu a:hover { background: #45a049; }
  </style>
</head>
<body>

  <h1>📊 Dashboard Tienda Online</h1>
  <div class="menu">
    <a href="ventas_producto.php">Ventas por Producto</a>
    <a href="ventas_cliente.php">Ventas por Cliente</a>
    <a href="ventas_diarias.php">Ventas Diarias</a>
    <a href="stock_alerta.php">Alerta de Stock</a>
  </div>

</body>
</html>