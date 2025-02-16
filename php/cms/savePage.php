<?php
header('Content-Type: application/json');
require_once "../_dbConfig.php"; // Ensure this file sets up `$con`
require_once "../../vendor/autoload.php"; // Include Twig

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Initialize Twig
$basepath = '../../elements/';
$loader = new FilesystemLoader([$basepath]);
$twig = new Environment($loader);

// Log the paths the loader is using
$loaderPaths = $loader->getPaths();
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
    // Delete old data
    $stmt = $con->prepare("DELETE FROM elements_data WHERE page_element_id IN (SELECT id FROM page_elements WHERE page_id = ?)");
    $stmt->bind_param("i", $pageId);
    $stmt->execute();
    $stmt->close();

    $stmt = $con->prepare("DELETE FROM page_elements WHERE page_id = ?");
    $stmt->bind_param("i", $pageId);
    $stmt->execute();
    $stmt->close();

    // Store new elements
    $renderData = []; // Data for rendering Twig
    foreach ($elements as $element) {
        $elementId = $element['id'];
        $position = $element['order'];

        // Insert into page_elements
        $stmt = $con->prepare("INSERT INTO page_elements (page_id, element_id, position) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $pageId, $elementId, $position);
        $stmt->execute();
        $pageElementId = $stmt->insert_id;
        $stmt->close();

        // Fetch element path
        $stmt = $con->prepare("SELECT path FROM elements WHERE id = ?");
        $stmt->bind_param("i", $elementId);
        $stmt->execute();
        $stmt->bind_result($elementPath);
        $stmt->fetch();
        $stmt->close();

        if (!$elementPath)
            continue;

        // Load variables
        $variables = [];
        foreach ($element['variables'] as $varName => $varValue) {
            $stmt = $con->prepare("INSERT INTO elements_data (page_element_id, variable_name, variable_value) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $pageElementId, $varName, $varValue);
            $stmt->execute();
            $stmt->close();

            $variables[$varName] = $varValue;
        }

        // Prepare for rendering
        $renderData[] = [
            'template' => $elementPath,
            'variables' => $variables
        ];
    }

    // Commit transaction
    $con->commit();

    // Render HTML page
    $htmlData = "";
    foreach ($renderData as $elementData) {
        $templateFile = $elementData['template'];
        $twigFile = $templateFile . '/' . $templateFile . '.twig';
        if (file_exists($basepath . $twigFile)) {

            $htmlData .= $twig->render($twigFile, $elementData['variables']);
        }
    }
    $htmlOutput = $twig->render("main.template.twig", ['content' => $htmlData]);

    // Save HTML output
    $distDir = "../../pages/dist/";
    if (!is_dir($distDir)) {
        mkdir($distDir, 0777, true);
    }

    file_put_contents($distDir . $pageId . ".html", $htmlOutput);

    echo json_encode(["status" => "success", "message" => "Page saved and rendered successfully"]);
} catch (Exception $e) {
    $con->rollback();
    echo json_encode(["status" => "error", "message" => "Failed to save page", "error" => $e->getMessage()]);
}
?>

