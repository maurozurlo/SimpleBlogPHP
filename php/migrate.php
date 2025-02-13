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
    content TEXT NOT NULL,
    ts DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1";

if (!$con->query($sql)) {
    die("Error creating posts table: " . $con->error);
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
