<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'proyecto2024');
define('DB_USER', 'root');  
define('DB_PASS', '');      

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}


function testConnection() {
    global $pdo;
    try {
        $pdo->query("SELECT 1");
        return "Conexión exitosa a la base de datos";
    } catch(PDOException $e) {
        return "Error de conexión: " . $e->getMessage();
    }
}