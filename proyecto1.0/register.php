<?php

include "seguridad.php";
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Verificar que las contraseñas coincidan
    if ($password !== $confirm_password) {
        $error_message = "Las contraseñas no coinciden.";
    } else {
        // Verificar si el usuario ya existe
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $existing_user = $stmt->fetch();

        if ($existing_user) {
            $error_message = "El nombre de usuario ya está en uso.";
        } else {
            // Hash de la contraseña y registro del usuario
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
            $stmt->execute([
                'username' => $username,
                'password' => $hashed_password
            ]);

            // Redirigir al inicio de sesión con un mensaje de éxito
            header("Location: login.php?mensaje=Cuenta creada con éxito. Inicia sesión.");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta - Sistema de Productos BUAP</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-semibold text-center text-gray-700">Crear una Cuenta</h2>
        <p class="text-center text-gray-600 mb-6">Sistema de Productos - BUAP</p>

        <?php if (isset($error_message)) : ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form action="register.php" method="POST" class="space-y-4">
            <div>
                <label for="username" class="block text-gray-600">Usuario</label>
                <input type="text" id="username" name="username" required
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-indigo-500" />
            </div>
            <div>
                <label for="password" class="block text-gray-600">Contraseña</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-indigo-500" />
            </div>
            <div>
                <label for="confirm_password" class="block text-gray-600">Confirmar Contraseña</label>
                <input type="password" id="confirm_password" name="confirm_password" required
                    class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-indigo-500" />
            </div>
            <button type="submit"
                class="w-full py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                Crear Cuenta
            </button>
        </form>

        <div class="mt-4 text-center">
            <a href="login.php" class="text-indigo-600 hover:underline">¿Ya tienes una cuenta? Inicia sesión</a>
        </div>
    </div>
</body>
</html>
