<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Menú Principal - Tienda Online</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #f4f6f9;
    }

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
</head>
<body>

<header>
  <h1>📊 Sistema Tienda Online</h1>
  <p>Gestión de productos, clientes, ventas y analíticas</p>
</header>

<nav>
  <a href="menu_crud_productos.html">📦 Productos</a>
  <a href="menu_crud_clientes.html">👥 Clientes</a>
  <a href="menu_crud_ventas.html">🛒 Ventas</a>
  <a href="analiticas_ventas.php">📈 Analíticas</a>
  <a href="graficos.php">📊 Gráficos</a>
</nav>

<main>
  <h2>Bienvenido al Sistema de Gestión</h2>
  <p>Selecciona una opción del menú para comenzar.</p>
</main>

<footer>
  &copy; 2025 Tienda Online - Proyecto Académico
</footer>

</body>
</html>
