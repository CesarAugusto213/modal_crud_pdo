<?php

session_start();

require '../config/database.php';

$id = $_POST['id'];

try {
    $sql = "DELETE FROM pelicula WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $dir = "posters";
        $poster = $dir . '/' . $id . ".jpg";
    
        if(file_exists($poster)) {
            unlink($poster);
        }

        $_SESSION['color'] = "success";
        $_SESSION['msg'] = "Registro eliminado.";
    } else {
        $_SESSION['color'] = "danger";
        $_SESSION['msg'] = "Error al eliminar registro.";
    }
} catch (PDOException $e) {
    $_SESSION['color'] = "danger";
    $_SESSION['msg'] = "Error de conexión: " . $e->getMessage();
}

header('Location: index.php');
?>