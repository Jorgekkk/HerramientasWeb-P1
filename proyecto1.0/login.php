<?php
require_once 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta para obtener el usuario
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Iniciar sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Usuario o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema de Productos BUAP</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-semibold text-center text-gray-700">Iniciar Sesión</h2>
        <p class="text-center text-gray-600 mb-6">Sistema de Productos - BUAP</p>

        <?php if (isset($error_message)) : ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="space-y-4">
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
            <button type="submit"
                class="w-full py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                Ingresar
            </button>
        </form>

        <!-- Botón para Crear una Cuenta -->
        <div class="mt-4 text-center">
            <p class="text-gray-600">¿No tienes cuenta?</p>
            <a href="register.php" 
               class="mt-2 inline-block px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400">
                Crear una cuenta
            </a>
        </div>

        <div class="mt-6 text-center text-gray-500">
            <small>© 2024 BUAP - Todos los derechos reservados</small>
        </div>
    </div>
</body>
</html>

