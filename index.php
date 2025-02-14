<?php
require_once 'vendor/autoload.php';
$requestUri = $_SERVER['REQUEST_URI'];

session_start();
$isLoggedIn = isset($_SESSION["state"]) && $_SESSION["state"] === true;

// Strip out the query string from the request URI
$parsedUrl = parse_url($requestUri);
$path = $parsedUrl['path']; // This gives you only the path without the query string

include "./partials/head.php";
include "./partials/navbar.php";

// Load routes
$routes = include('./php/routes.php');
$params = [];
// Match the request URI against the routes
$page = null;

foreach ($routes as $path => $route) {
  // Create the regex pattern to match dynamic parameters (like :slug)
  $pattern = preg_replace('/:([\w]+)/', '([^/]+)', $path);
  $pattern = '#^' . $pattern . '$#'; // Ensure it's the full match

  if (preg_match($pattern, $requestUri, $matches)) {
    // Capture dynamic parameters (e.g., :slug)
    preg_match_all('/:([\w]+)/', $path, $paramNames); // Extract parameter names (e.g., "slug")
    array_shift($matches); // Remove the full match from the array

    // Populate the $params array with captured values, using the parameter names
    foreach ($paramNames[1] as $index => $paramName) {
      $params[$paramName] = $matches[$index];
    }

    // Set the page to include
    $page = $route;
    break;
  }
}

if ($page) {
  include "./pages/" . $page; // Include the matched page
} else {
  echo '404 Not Found'; // Show a 404 page if no route matches
}

include "./partials/footer.php";

