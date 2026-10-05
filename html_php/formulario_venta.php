<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Venta</title>
   <link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>
  <h2>Formulario para Registrar una Venta</h2>
  <form action="procesar_venta.php" method="POST">
    <label for="cliente_id">Cliente:</label>
    <select name="cliente_id" required>
      <option value="">--Seleccione un cliente--</option>
      <?php
      $clientes = $conexion->query("SELECT id, nombre FROM clientes");
      while ($cliente = $clientes->fetch_assoc()) {
          echo "<option value='{$cliente['id']}'>{$cliente['nombre']}</option>";
      }
      ?>
    </select><br><br>

    <label for="producto_id">Producto:</label>
    <select name="producto_id" required>
      <option value="">--Seleccione un producto--</option>
      <?php
      $productos = $conexion->query("SELECT id, nombre FROM productos");
      while ($producto = $productos->fetch_assoc()) {
          echo "<option value='{$producto['id']}'>{$producto['nombre']}</option>";
      }
      ?>
  
 </select><br><br>
    <label for="cantidad">Cantidad:</label>
    <input type="number" name="cantidad" min="1" required><br><br>

   
    <label for="fecha">Fecha de Venta:</label>
    <input type="date" name="fecha" required><br><br>

    <input type="submit" value="Registrar Venta">
  </form>
</body>
</html>

<?php $conexion->close(); ?>
