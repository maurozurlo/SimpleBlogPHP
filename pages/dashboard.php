<?php
require_once("php/_protectedRoute.php");
require_once("php/_dbConfig.php");

$section = $params['section'] ?? "";
?>

<div class="container">
  <div class="row">
    <div class="col-md-2">
      <nav class="nav nav-pills flex-column">
        <a class="nav-link <?= $section == "" ? 'active' : "" ?>" href="/backoffice">Dashboard</a>
        <a class="nav-link <?= $section == "home" ? 'active' : "" ?>" href="/backoffice/home">HomePage</a>
        <a class="nav-link <?= $section == "posts" ? 'active' : "" ?>" href="/backoffice/posts">Posts</a>
        <a class="nav-link <?= $section == "users" ? 'active' : "" ?>" href="/backoffice/users">Users</a>
      </nav>
    </div>
    <div class="col-md-10"><?php
    switch ($section) {
      case "":
        include "./pages/backoffice/dash.php";
        break;
      case "posts":
        include "./pages/backoffice/posts-view.php";
        break;
      case "users":
        include "./pages/backoffice/users-view.php";
        break;
      default:
        echo "WIP";
        break;
    }
    ?></div>
  </div>
</div>

