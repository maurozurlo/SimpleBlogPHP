<?php
include "_dbConfig.php";
$postdata = file_get_contents("php://input");
$data = json_decode($postdata, true);

if (!isset($data['user']) || !isset($data['pass'])) {
	err();
}

session_start();
$_SESSION["state"] = false;

$user = trim($data['user']);
$pass = $data['pass'];

$stmt = $con->prepare("SELECT id, username, password FROM users WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows < 1) {
	err();
}

$stmt->bind_result($dbUserId, $dbUser, $dbPass);
$stmt->fetch();

if (!password_verify($pass, $dbPass)) {
	err();
}

$_SESSION["state"] = true;
$_SESSION["name"] = $dbUser;
$_SESSION["userId"] = $dbUserId;
echo json_encode(['status' => 'success', 'redirectUrl' => '/backoffice']);
exit;

function err()
{
	echo json_encode(['status' => 'error', 'message' => 'Wrong credentials.']);
	exit;
}
