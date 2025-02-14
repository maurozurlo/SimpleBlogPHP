<?php
return [
    '/' => 'home.php',
    '/about' => 'about.php',
    '/backoffice' => 'dashboard.php',
    '/backoffice/:section' => 'dashboard.php',
    '/login' => 'login.php',
    '/logout' => 'logout.php',
    '/posts' => 'posts.php',
    '/posts/:slug' => 'post.php',
    '/editor/posts/' => 'backoffice/posts-editor.php',
    '/editor/posts/:id' => 'backoffice/posts-editor.php',
    '/editor/users/' => 'backoffice/users-editor.php',
    '/editor/users/:id' => 'backoffice/users-editor.php',
];