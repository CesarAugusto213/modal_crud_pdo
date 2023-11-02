<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=cinema", "root", "mysql");
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>