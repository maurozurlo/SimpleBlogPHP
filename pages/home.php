<div class="container">
    <div class="row my-2">
        <div class="col-md-12 mx-auto">
            <h1 class="mt-4 text-center">
                <a href="/">SimpleBlogPHP</a>
            </h1>
        </div>
        <div
            class="col-md-8 mx-auto">

            <?php if ($isLoggedIn): ?>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="mr-2">Hi,
                        <?php echo htmlspecialchars($_SESSION["name"]); ?>
                        !</span>
                    <a class="btn btn-outline-secondary btn-sm" href="/dashboard">Dashboard</a>
                </div>
            <?php else: ?>
                <small class="text-right d-block">
                    <a class="btn btn-outline-secondary btn-sm" href="/login">Login</a>
                </small>
            <?php endif; ?>
        </div>
    </div>
</div>
<hr>

<div
    class="container"><?php
    require_once("./php/_dbConfig.php");
    require_once("./vendor/parsedown-1.7.4/Parsedown.php");

    $parsedown = new Parsedown();
    $parsedown->setBreaksEnabled(true);

    $sql = 'SELECT id, idAuthor, title, content, ts FROM posts WHERE state = "Published" ORDER BY ts DESC';
    $result = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_array($result)) {
        echo "<div class='row'><div class='col-md-8 mx-auto'>";
        echo "<h2>{$row['title']}</h2>";
        echo $parsedown->text(urldecode($row['content']));
        echo "<small class='d-block text-right font-italic pb-2'> Published by {$row['idAuthor']}, {$row['ts']}</small>";
        echo "</div><div class='col-md-12'><hr></div></div>";
    }
    ?>
</div>

