<?php
include "_dbConfig.php"; // Ensure this file correctly initializes $con

// Configuration
$rootUser = 'admin';  // Change this if needed
$rootPass = 'admin';  // Change this to a secure password
$hashedPass = password_hash($rootPass, PASSWORD_DEFAULT);

// Create `users` table if it doesn’t exist
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(4) NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

if (!$con->query($sql)) {
    die("Error creating users table: " . $con->error);
}

// Create `posts` table if it doesn’t exist
$sql = "CREATE TABLE IF NOT EXISTS posts (
    id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    idAuthor VARCHAR(255) NOT NULL,
    state VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content TEXT NOT NULL,
    ts DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

if (!$con->query($sql)) {
    die("Error creating posts table: " . $con->error);
}

// CMS Capabilities
$sql = "CREATE TABLE IF NOT EXISTS pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);";

if (!$con->query($sql)) {
    die("Error creating pages table: " . $con->error);
}

$sql = "CREATE TABLE IF NOT EXISTS elements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    path VARCHAR(255) NOT NULL UNIQUE -- Path to the JSON definition file
);";

if (!$con->query($sql)) {
    die("Error creating elements table: " . $con->error);
}

$sql = "CREATE TABLE IF NOT EXISTS page_elements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_id INT NOT NULL,
    element_id INT NOT NULL,
    position INT NOT NULL DEFAULT 0, -- Defines order on the page
    FOREIGN KEY (page_id) REFERENCES pages(id) ON DELETE CASCADE,
    FOREIGN KEY (element_id) REFERENCES elements(id) ON DELETE CASCADE
);";

if (!$con->query($sql)) {
    die("Error creating page_elements table: " . $con->error);
}

$sql = "CREATE TABLE IF NOT EXISTS elements_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_element_id INT NOT NULL,
    variable_name VARCHAR(255) NOT NULL,
    variable_value TEXT NOT NULL,
    FOREIGN KEY (page_element_id) REFERENCES page_elements(id) ON DELETE CASCADE
);";

if (!$con->query($sql)) {
    die("Error creating elements_data table: " . $con->error);
}

// Check if the root user already exists
$stmt = $con->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $rootUser);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    // Insert root user with hashed password
    $stmt = $con->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $rootUser, $hashedPass);
    if ($stmt->execute()) {
        echo "Root user created successfully.\n";
    } else {
        die("Error inserting root user: " . $stmt->error);
    }
} else {
    echo "Root user already exists.\n";
}

$stmt->close();
$con->close();
