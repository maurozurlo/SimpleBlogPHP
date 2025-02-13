<?php
include "_dbConfig.php";

if (!isset($_POST['user']) || !isset($_POST['pass'])) {
	err();
}

session_start();
$_SESSION["state"] = false;

// Get user input
$user = trim($_POST['user']);
$pass = $_POST['pass'];

// Query user securely
QueryDatabase($user, $pass);

function QueryDatabase($user, $pass)
{
	global $con;

	// Prepared statement to prevent SQL injection
	$stmt = $con->prepare("SELECT username, password FROM users WHERE username = ?");
	$stmt->bind_param("s", $user);
	$stmt->execute();
	$stmt->store_result();

	// Check if user exists
	if ($stmt->num_rows < 1) {
		err();
	}

	// Get password hash
	$stmt->bind_result($dbUser, $dbPass);
	$stmt->fetch();

	// Verify password
	if (!password_verify($pass, $dbPass)) {
		err();
	}

	// Login successful
	$_SESSION["state"] = true;
	$_SESSION["name"] = $dbUser;

	echo "dashboard.php";
	exit;
}

function err()
{
	header("HTTP/1.1 401 Unauthorized");
	exit;
}
