<?php
$requestUri = $_SERVER['REQUEST_URI'];
session_start();
$isLoggedIn = isset($_SESSION["state"]) && $_SESSION["state"] === true;

// Strip out the query string from the request URI
$parsedUrl = parse_url($requestUri);
$path = $parsedUrl['path']; // This gives you only the path without the query string

include "./partials/head.php";
include "./partials/navbar.php";
// Define routes
switch ($path) {
  case '/':
    include './pages/home.php';
    break;
  case '/about':
    include './pages/about.php';
    break;
  case '/editor':
    include './pages/editor.php';
    break;
  case '/dashboard':
    include './pages/dashboard.php';
    break;
  case '/login':
    include './pages/login.php';
    break;
  case '/logout':
    include './pages/logout.php';
    break;
}

include "./partials/footer.php";

