<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
    if ($stmt->execute([$username, $email, $password])) {
        header('Location: index.php?success=registered');
    } else {
        echo "Error al registrar el usuario.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        /* Estilos generales */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-image: url('https://png.pngtree.com/background/20220731/original/pngtree-light-green-geometric-background-picture-image_1910209.jpg');
            background-size: cover;  /* Asegura que la imagen cubra toda la página */
            background-position: center;  /* Centra la imagen de fondo */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            color: #fff;  /* Asegura que el texto sea legible sobre el fondo */
        }

        h1 {
            margin-top: 150px;
            font-size: 2rem;
            margin-bottom: 10px; /* Se reduce la separación con el formulario */
            color: black;
        }

        footer {
            background-color: #6c63ff;
            color: #fff;
            padding: 10px;
            text-align: center;
            width: 100%;
            margin-top: auto; 
        }

        form {
            background-color: rgba(255, 255, 255, 0.9); /* Fondo blanco semi-transparente */
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        input {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        input:focus {
            border-color: #6c63ff;
            outline: none;
        }

        button {
            width: 100%;
            padding: 15px;
            background-color: #abebc6;
            color: black;
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #a2d9ce;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: black;
            text-decoration: none;
            font-size: 1rem;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Registro de usuario</h1>
    <form action="register.php" method="POST">
        <input type="text" name="username" placeholder="Nombre de usuario" required>
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Registrarse</button>
    </form>
    <a href="index.php">¿Ya tienes cuenta? Inicia sesión</a>

    <footer>
        <p> Elaborado por: Luis Alexis Nava Najera y Bernardino Jijon Ramirez </p>
    </footer>

</body>
</html>
