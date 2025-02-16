<?php
header('Content-Type: application/json');
include "../_dbConfig.php"; // Ensure this file sets up `$con` for database connection

// Get the JSON payload
$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['page']) || !isset($input['elements']) || !is_array($input['elements'])) {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit;
}

$pageId = $input['page'];
$elements = $input['elements'];

// Start transaction
$con->begin_transaction();

try {
    // First, delete from elements_data where page_element_id matches existing page_elements entries
    $stmt = $con->prepare("
        DELETE FROM elements_data 
        WHERE page_element_id IN (SELECT id FROM page_elements WHERE page_id = ?)
    ");
    $stmt->bind_param("i", $pageId);
    $stmt->execute();
    $stmt->close();

    // Then, delete from page_elements
    $stmt = $con->prepare("DELETE FROM page_elements WHERE page_id = ?");
    $stmt->bind_param("i", $pageId);
    $stmt->execute();
    $stmt->close();

    // Insert new elements
    foreach ($elements as $element) {
        $elementId = $element['id'];
        $position = $element['order'];

        // Insert into page_elements
        $stmt = $con->prepare("INSERT INTO page_elements (page_id, element_id, position) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $pageId, $elementId, $position);
        $stmt->execute();
        $pageElementId = $stmt->insert_id; // Get inserted ID
        $stmt->close();

        // Insert element variables into elements_data
        foreach ($element['variables'] as $varName => $varValue) {
            // Ensure $varValue is a string, convert if necessary
            if (!is_string($varValue)) {
                $varValue = json_encode($varValue);
            }

            $stmt = $con->prepare("INSERT INTO elements_data (page_element_id, variable_name, variable_value) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $pageElementId, $varName, $varValue);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Commit transaction
    $con->commit();
    echo json_encode(["status" => "success", "message" => "Page saved successfully"]);
} catch (Exception $e) {
    $con->rollback(); // Rollback in case of error
    echo json_encode(["status" => "error", "message" => "Failed to save page", "error" => $e->getMessage()]);
}
?>

