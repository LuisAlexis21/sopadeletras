<?php
$host = '127.0.0.1';
$db = 'game';
$user = 'root'; // Cambia esto si tu usuario de MySQL no es "root"
$pass = ''; // Cambia esto si tu contraseña de MySQL no está vacía

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
