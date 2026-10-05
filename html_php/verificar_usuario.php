<?php
// Capturar los datos del formulario
$usuario = $_POST['usuario'];
$password = $_POST['password'];

// Nombre de la base de datos
$nombreBaseDatos = 'tienda_online';

// Intentar conectar a la base de datos MySQL
$conexion = new mysqli('localhost', $usuario, $password, $nombreBaseDatos);

// Verificar si la conexión fue exitosa
if ($conexion->connect_error) {
    // Si hay error, mostrar un mensaje de error
    die("<h3> no existe el usuario: No se pudo conectar a la base de datos.</h3> <p>" . $conexion->connect_error . "</p>");
} else {
    // Si la conexión es exitosa, mostrar un mensaje de éxito
     echo "<h3>Conexión exitosa a la base de datos '$nombreBaseDatos'.</h3>";
     echo "<h3>Bienvenido usuario ' $usuario'.</h3>";
    // Aquí podrías hacer consultas o acciones adicionales si es necesario
}

// Cerrar la conexión
$conexion->close();
?>
