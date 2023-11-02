<?php

require '../config/database.php';

$id = $_POST['id'];

try {
    $sql = "SELECT id, nombre, descripcion, id_genero 
            FROM pelicula WHERE id = :id LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $pelicula = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($pelicula, JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(["error" => "No se encontró la película."], JSON_UNESCAPED_UNICODE);
    }
} catch (PDOException $e) {
    echo json_encode(["error" => "Error de conexión: " . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}

?>