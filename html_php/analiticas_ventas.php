<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Total de ventas
$total_ventas = $conexion->query("SELECT COUNT(*) AS total FROM vista_ventas")->fetch_assoc()['total'];

// Total de ingresos
$ingresos_totales = $conexion->query("
    SELECT SUM(total) AS total
    FROM vista_ventas
")->fetch_assoc()['total'];

// Producto más vendido
$producto_mas_vendido = $conexion->query("
    SELECT producto, SUM(cantidad) AS total_vendido
    FROM vista_ventas 
    
")->fetch_assoc();

// Cliente con más compras
$cliente_top = $conexion->query("
    SELECT cliente, COUNT(*) AS num_compras
    FROM vista_ventas     
")->fetch_assoc();

// Promedio por venta
$promedio_venta = $conexion->query("
    SELECT AVG(total) AS promedio
    FROM vista_ventas
")->fetch_assoc()['promedio'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Analíticas de Ventas</title>
  <style>
    body { font-family: Arial; margin: 40px;
      background: #f4f6f9;
    }
    
    h2 { color: #333; }
    .box { margin-bottom: 20px; padding: 15px; border: 1px solid #ccc; background-color: #f9f9f9; }
    

    header {
      background: #2c3e50;
      color: white;
      padding: 15px;
      text-align: center;
    }

    nav {
      background: #34495e;
      display: flex;
      justify-content: center;
      padding: 10px 0;
    }

    nav a {
      color: white;
      text-decoration: none;
      margin: 0 15px;
      padding: 10px 20px;
      transition: background 0.3s;
    }

    nav a:hover {
      background: #1abc9c;
      border-radius: 5px;
    }

    main {
      padding: 30px;
      text-align: center;
    }

    footer {
      background: #2c3e50;
      color: white;
      text-align: center;
      padding: 10px;
      position: fixed;
      bottom: 0;
      width: 100%;
    }
  </style>
  </style>
</head>
<body>
<header>
  <h1>📊 Sistema Tienda Online</h1>
  <p>Gestión de ventas</p>
</header>
<main>
 <h2>📊 Analíticas Básicas de Ventas</h2>
  <p>Selecciona una opción del menú para comenzar.</p>
</main>


  <div class="box"><strong>Total de ventas registradas:</strong> <?= $total_ventas ?></div>

  <div class="box"><strong>Ingresos totales:</strong> $<?= number_format($ingresos_totales, 2) ?></div>

  <div class="box"><strong>Producto más vendido:</strong> <?= $producto_mas_vendido['producto'] ?> (<?= $producto_mas_vendido['total_vendido'] ?> unidades)</div>

  <div class="box"><strong>Cliente con más compras:</strong> <?= $cliente_top['cliente'] ?> (<?= $cliente_top['num_compras'] ?> compras)</div>

  <div class="box"><strong>Promedio por venta:</strong> $<?= number_format($promedio_venta, 2) ?></div>
  


<footer>
  &copy; 2025 Tienda Online - Proyecto Académico
</footer>

 
  <p style="text-align:center;"><a href="menu_index.php">⬅ Volver al Menú</a></p>
</body>
</html>

<?php $conexion->close(); ?>
