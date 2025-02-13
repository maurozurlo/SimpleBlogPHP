<?php
require_once("./php/_dbConfig.php");
require_once("./vendor/parsedown-1.7.4/Parsedown.php");

$parsedown = new Parsedown();
$parsedown->setBreaksEnabled(true);

// Initialize variables
$title = $state = $content = $ts = $author = $slug = "";

// Get slug from parameters (ensure it is safe)
if (isset($params['slug'])) {
    $slug = $params['slug'];
} else {
    echo "Slug is missing.";
    exit;
}

// Prepare SQL query to fetch post details by slug
$sql = 'SELECT id, idAuthor, title, content, ts, state FROM posts WHERE state = "Published" AND slug = ?';

if ($stmt = mysqli_prepare($con, $sql)) {
    // Bind parameters and execute query
    mysqli_stmt_bind_param($stmt, 's', $slug);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    // Check if any result found
    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Bind result variables
        mysqli_stmt_bind_result($stmt, $id, $author, $title, $content, $ts, $state);

        // Fetch the data
        while (mysqli_stmt_fetch($stmt)) {
            // Assign fetched values to variables
            $author = htmlspecialchars($author);
            $title = htmlspecialchars($title);
            $content = urldecode($content); // Decode content if it's URL encoded
            $ts = htmlspecialchars($ts);
        }

        // Free result set
        mysqli_stmt_free_result($stmt);
    } else {
        echo "No post found with the provided slug.";
        exit;
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "Failed to prepare the SQL statement.";
    exit;
}

?>

<div class="container">


    <div class="row">
        <div class="col-md-8 mx-auto">
            <h2><?= $title ?></h2>
            <?= $parsedown->text($content) ?>
            <small class="d-block text-right font-italic pb-2">
                Published by
            <?= "{$author}', '" ?>
                <?= $ts ?>
            </small>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
    </div>

</div>

