<?php

session_start();

require '../config/database.php';

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$genero = $_POST['genero'];

try {
    $sql = "UPDATE pelicula 
            SET nombre = :nombre,
                descripcion = :descripcion,
                id_genero = :genero
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
    $stmt->bindParam(':genero', $genero, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $_SESSION['color'] = "success";
        $_SESSION['msg'] = "Registro actualizado.";

        if ($_FILES['poster']['error'] == UPLOAD_ERR_OK) {
            $permitidos = array("image/jpg", "image/jpeg");

            if (in_array($_FILES['poster']['type'], $permitidos)) {
                $dir = "posters";

                $info_img = pathinfo($_FILES['poster']['name']);

                $poster = $dir . '/' . $id . "." . $info_img['extension'];

                if (!file_exists($dir)) {
                    mkdir($dir, 0777);
                }

                if (!move_uploaded_file($_FILES['poster']['tmp_name'], $poster)) {
                    $_SESSION['color'] = "danger";
                    $_SESSION['msg'] .= "<br>Error al actualizar imagen.";
                }
            } else {
                $_SESSION['color'] = "danger";
                $_SESSION['msg'] .= "<br>Formato de imagen no permitido.";
            }
        }
    } else {
        $_SESSION['color'] = "danger";
        $_SESSION['msg'] = "Error al actualizar imagen.";
    }
} catch (PDOException $e) {
    $_SESSION['color'] = "danger";
    $_SESSION['msg'] = "Error de conexión: " . $e->getMessage();
}

header('Location: index.php');
?>