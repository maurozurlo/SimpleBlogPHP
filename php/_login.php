<?php
include "_dbConfig.php";

if (!isset($_POST['user']) && !isset($_POST['pass'])) {
	err();
}

session_start();
$_SESSION["state"] = false;
//Geting info
$user = $con->real_escape_string($_POST['user']);
$pass = $con->real_escape_string($_POST['pass']);
//Query to select the user
QueryDatabase($user, $pass);

function QueryDatabase($user, $pass)
{
	global $con;
	$sql = "select username, password from users where username = '{$user}' and password = '{$pass}'";
	$result = $con->query($sql) or die("Failed to Query database " . $con->error);
	// Check if user exists
	if ($result->num_rows < 1) {
		err();
	}
	// Login
	$_SESSION["state"] = true;
	$_SESSION["name"] = $user;
	// Redirect
	echo "dashboard.php";
	exit;
}

function err()
{
	header("HTTP/1.1 401 Unauthorized");
	exit;
}
