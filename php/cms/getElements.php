<?php
header('Content-Type: application/json');
include "../_dbConfig.php"; // Ensure this file sets up `$con` for database connection

$elementsDir = '../../elements/';
$elements = [];

if (is_dir($elementsDir)) {
    $folders = scandir($elementsDir);

    foreach ($folders as $folder) {
        if ($folder === '.' || $folder === '..')
            continue;

        $filename = $folder;
        $jsonPath = $elementsDir . $folder . '/' . $folder . '.json';

        if (file_exists($jsonPath)) {
            $jsonContent = file_get_contents($jsonPath);
            $elementData = json_decode($jsonContent, true);

            if ($elementData) {
                // Check if element exists in DB
                $stmt = $con->prepare("SELECT id FROM elements WHERE path = ?");
                $stmt->bind_param("s", $filename);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $elementData['id'] = $row['id'];
                } else {
                    // Insert into database if not found
                    $insertStmt = $con->prepare("INSERT INTO elements (path) VALUES (?)");
                    $insertStmt->bind_param("s", $filename);
                    $insertStmt->execute();
                    $elementData['id'] = $insertStmt->insert_id;
                    $insertStmt->close();
                }

                $stmt->close();
                $elements[] = $elementData;
            }
        }
    }
}

echo json_encode($elements);
?>

