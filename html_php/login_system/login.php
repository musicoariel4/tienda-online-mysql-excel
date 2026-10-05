<?php
session_start();

$DB_HOST = "localhost";
$DB_NAME = "tienda_online";

$username = $_POST["username"];
$password = $_POST["password"];

// Intentar conexión con las credenciales que ingresó el usuario
$conn = @new mysqli($DB_HOST, $username, $password, $DB_NAME);

if ($conn->connect_error) {
    echo "❌ Usuario o contraseña incorrectos.";
} else {
    $_SESSION["username"] = $username;
    $_SESSION["password"] = $password; // ⚠️ opcional: no recomendado en producción
    header("Location: index.php");
    exit;
}
?>