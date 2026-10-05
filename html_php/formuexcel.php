<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Clientes</title>
</head>
<body>
    <h2>Ingresar datos del cliente</h2>
    <form action="exportar_excel.php" method="post">
        <label>ID:</label><br>
        <input type="number" name="id"><br><br>
        
        <label>Nombre:</label><br>
        <input type="text" name="nombre"><br><br>
        
        <label>Email:</label><br>
        <input type="email" name="email"><br><br>
        
        <input type="submit" value="Exportar a Excel">
    </form>
</body>
</html>
