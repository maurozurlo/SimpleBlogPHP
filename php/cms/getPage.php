<?php
header('Content-Type: application/json');
include "../_dbConfig.php"; // Ensure this sets up `$con`

// Get pageId from the query string
if (!isset($_GET['pageId']) || !is_numeric($_GET['pageId'])) {
    echo json_encode(["status" => "error", "message" => "Invalid pageId"]);
    exit;
}

$pageId = intval($_GET['pageId']);

// Fetch page elements and associated data
$query = "
    SELECT pe.id AS page_element_id, pe.element_id, pe.position, ed.variable_name, ed.variable_value
    FROM page_elements pe
    LEFT JOIN elements_data ed ON pe.id = ed.page_element_id
    WHERE pe.page_id = ?
    ORDER BY pe.position ASC
";

$stmt = $con->prepare($query);
$stmt->bind_param("i", $pageId);
$stmt->execute();
$result = $stmt->get_result();

$pageData = [];
while ($row = $result->fetch_assoc()) {
    $pageElementId = $row['page_element_id'];

    // If the element is not in the array yet, initialize it
    if (!isset($pageData[$pageElementId])) {
        $pageData[$pageElementId] = [
            "pageElementId" => $pageElementId,
            "id" => $row['element_id'],
            "order" => $row['position'],
            "variables" => []
        ];
    }

    // Add variable data
    if ($row['variable_name']) {
        $pageData[$pageElementId]['variables'][$row['variable_name']] = $row['variable_value'];
    }
}

$stmt->close();

// Re-index array (remove associative keys
// Re-index array (remove associative keys)
echo json_encode(array_values($pageData));
?>

