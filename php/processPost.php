<?php
session_start();

include "_dbConfig.php";
include "_sanitize.php";

$sanitizer = new HtmlSanitizer();
$postdata = file_get_contents("php://input");
$data = json_decode($postdata, true);

header('Content-Type: application/json');

if (isset($data['action'])) {
    $action = $data['action'];
    $id = $data['id'] ?? null;
    $title = $sanitizer->sanitize($data['title'] ?? '');
    $date = $data['date'] ?? date("Y-m-d H:i:s");
    $state = $data['state'] ?? '';
    $content = $sanitizer->sanitize(isset($data['content']) ? $data['content'] : "");

    $author = $_SESSION['name'] ?? '';

    try {
        switch ($action) {
            case 'create':
                createPost($title, $state, $content, $author, $date);
                echo json_encode(['status' => 'success', 'message' => 'Post created successfully']);
                break;
            case 'update':
                updatePost($title, $state, $content, $author, $date, $id);
                echo json_encode(['status' => 'success', 'message' => 'Post updated successfully']);
                break;
            case 'delete':
                deletePost($id);
                echo json_encode(['status' => 'success', 'message' => 'Post deleted successfully', 'redirectUrl' => "/dashboard"]);
                break;
            default:
                echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
                break;
        }
    } catch (Exception $e) {
        // Log error securely
        error_log("Database error: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'An error occurred while processing your request']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No action specified']);
}

function deletePost($id)
{
    global $con;
    $stmt = $con->prepare("DELETE FROM `posts` WHERE `id` = ?");
    $stmt->bind_param("i", $id);
    executeStatement($stmt);
}

function createPost($title, $state, $content, $author, $date)
{
    global $con;
    $stmt = $con->prepare("INSERT INTO `posts` (`title`, `state`, `content`, `ts`, `idAuthor`) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $state, $content, $date, $author);
    executeStatement($stmt);
}

function updatePost($title, $state, $content, $author, $date, $id)
{
    global $con;
    $stmt = $con->prepare("UPDATE `posts` SET `title` = ?, `state` = ?, `content` = ?, `ts` = ?, `idAuthor` = ? WHERE `id` = ?");
    $stmt->bind_param("sssssi", $title, $state, $content, $date, $author, $id);
    executeStatement($stmt);
}

function executeStatement($stmt)
{
    if (!$stmt->execute()) {
        throw new Exception("Database query failed: " . $stmt->error);
    }
    $stmt->close();
}
?>

