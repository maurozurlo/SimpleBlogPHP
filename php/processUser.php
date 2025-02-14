<?php
session_start();

include "_dbConfig.php";
include "_sanitize.php";
include "helpers.php";

$sanitizer = new HtmlSanitizer();
$postdata = file_get_contents("php://input");
$data = json_decode($postdata, true);

header('Content-Type: application/json');

if (isset($data['action'])) {
    $action = $data['action'];
    $id = $data['id'] ?? null;
    $username = $sanitizer->sanitize($data['username'] ?? '');
    $password = $data['password'] ?? null;
    $hashedPassword = $password ? password_hash($password, PASSWORD_BCRYPT) : null;

    try {
        switch ($action) {
            case 'create':
                createUser($username, $hashedPassword);
                echo json_encode(['status' => 'success', 'message' => 'User created successfully']);
                break;
            case 'update':
                updateUser($id, $username, $hashedPassword);
                echo json_encode(['status' => 'success', 'message' => 'User updated successfully']);
                break;
            case 'delete':
                if ($id == $_SESSION['userId']) {
                    echo json_encode(['status' => 'error', 'message' => 'Cannot delete your own user']);
                    exit;
                }
                deleteUser($id);
                echo json_encode(['status' => 'success', 'message' => 'User deleted successfully', 'redirectUrl' => "/backoffice/users"]);
                break;
            default:
                echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
                break;
        }
    } catch (Exception $e) {
        error_log("Database error: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'An error occurred while processing your request']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No action specified']);
}

function createUser($username, $hashedPassword)
{
    global $con;
    $stmt = $con->prepare("INSERT INTO `users` (`username`, `password`) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);
    executeStatement($stmt);
}

function updateUser($id, $username, $hashedPassword)
{
    global $con;
    if ($hashedPassword) {
        $stmt = $con->prepare("UPDATE `users` SET `username` = ?, `password` = ? WHERE `id` = ?");
        $stmt->bind_param("ssi", $username, $hashedPassword, $id);
    } else {
        $stmt = $con->prepare("UPDATE `users` SET `username` = ? WHERE `id` = ?");
        $stmt->bind_param("si", $username, $id);
    }
    executeStatement($stmt);
}

function deleteUser($id)
{
    global $con;
    $stmt = $con->prepare("DELETE FROM `users` WHERE `id` = ?");
    $stmt->bind_param("i", $id);
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

