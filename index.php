<?php
require 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: game.html');
    } else {
        echo "Correo o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sopa de Letras</title>
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
            background-size: cover;
            background-position: center;
            color: #fff;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh; 
        }

        /* Estilos para el header y el footer */
        header {
            background-color: #6c63ff;
            color: #fff;
            padding: 20px;
            text-align: center;
            width: 100%;
        }

        header h1 {
            font-size: 3rem;
            display: inline-block;
            animation: color-change 3s infinite alternate, move-letters 5s infinite linear;
        }


        /* Animación de movimiento de letras */
        @keyframes move-letters {
            0%, 100% { transform: translateY(0); }
            25% { transform: translateY(-10px); }
            50% { transform: translateY(10px); }
            75% { transform: translateY(-5px); }
        }

        h2 {
            margin-top: 100px;
            font-size: 2rem;
            margin-bottom: 0;
            color: black;
            text-align: center;
        }

        footer {
            background-color: #6c63ff;
            color: #fff;
            padding: 10px;
            text-align: center;
            width: 100%;
            margin-top: auto; 
        }

        /* Estilos para el formulario */
        form {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin: 20px auto; 
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
    <header>
        <h1> Sopa de letras </h1>
    </header>

    <h2>Inicio de sesión</h2>
    <form action="index.php" method="POST">
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Iniciar sesión</button>
    </form>

    <a href="register.php">¿No tienes cuenta? Regístrate aquí</a>

    <footer>
        <p> Elaborado por: Luis Alexis Nava Najera y Bernardino Jijon Ramirez </p>
    </footer>
</body>
</html>
