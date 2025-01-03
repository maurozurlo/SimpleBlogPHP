<?php
include "_auth.php";
include "_dbConfig.php";
include "_sanitize.php";

$sanitizer = new HtmlSanitizer();

if(isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    $id = $_POST['id'] ?? null;
    $titulo = $sanitizer->sanitize($_POST['titulo'] ?? '');
    $fecha = $_POST['fecha'] ? $_POST['fecha'] : date("Y-m-d H:i:s");
    $estado = $_POST['estado'] ?? '';
    $contenido = $sanitizer->sanitize($_POST['contenido']);
    $autor = $_SESSION['name'] ?? '';

    try {
        switch ($accion) {
            case 'nuevo':
                createPost($titulo, $estado, $contenido, $autor, $fecha);
                break;
            case 'actualiza':
                updatePost($titulo, $estado, $contenido, $autor, $fecha, $id);
                break;
            case 'eliminar':
                deletePost($id);
                break;
            default:
                echo "error";
                break;
        }
    } catch (Exception $e) {
        // Log error securely
        error_log("Database error: " . $e->getMessage());
        echo "An error occurred while processing your request";
    }
}

function deletePost($id) {
    global $con;
    $stmt = $con->prepare("DELETE FROM `posts` WHERE `id` = ?");
    $stmt->bind_param("i", $id);
    executeStatement($stmt);
}

function createPost($titulo, $estado, $contenido, $autor, $fecha) {
    global $con;
    $stmt = $con->prepare("INSERT INTO `posts` (`title`, `state`, `content`, `ts`, `idAuthor`) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $titulo, $estado, $contenido, $fecha, $autor);
    executeStatement($stmt);
}

function updatePost($titulo, $estado, $contenido, $autor, $fecha, $id) {
    global $con;
    $stmt = $con->prepare("UPDATE `posts` SET `title` = ?, `state` = ?, `content` = ?, `ts` = ?, `idAuthor` = ? WHERE `id` = ?");
    $stmt->bind_param("sssssi", $titulo, $estado, $contenido, $fecha, $autor, $id);
    executeStatement($stmt);
}

function executeStatement($stmt) {
    if (!$stmt->execute()) {
        throw new Exception("Database query failed: " . $stmt->error);
    }
    $stmt->close();
    echo "dashboard.php";
}