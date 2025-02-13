<?php
include "_auth.php";
include "_dbConfig.php";
include "_sanitize.php";

$sanitizer = new HtmlSanitizer();
$postdata = file_get_contents("php://input");
$data = json_decode($postdata, true); // Decode JSON as an associative array

if (isset($data['action'])) {
    $action = $data['action'];
    $id = $data['id'] ?? null;
    $title = $sanitizer->sanitize($data['title'] ?? '');
    $date = $data['date'] ? $data['date'] : date("Y-m-d H:i:s");
    $state = $data['state'] ?? '';
    $content = $sanitizer->sanitize($data['content']);

    $author = $_SESSION['name'] ?? '';

    try {
        switch ($action) {
            case 'create':
                createPost($title, $state, $content, $author, $date);
                break;
            case 'update':
                updatePost($title, $state, $content, $author, $date, $id);
                break;
            case 'delete':
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