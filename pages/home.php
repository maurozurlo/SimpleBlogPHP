<div
    class="container"><?php
    require_once("./php/_dbConfig.php");

    $parsedown = new Parsedown();
    $parsedown->setBreaksEnabled(true);

    $sql = 'SELECT id, idAuthor, title, content, slug, ts FROM posts WHERE state = "Published" ORDER BY ts DESC';
    $result = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_array($result)) {
        echo "<div class='row'><div class='col-md-8 mx-auto'>";
        echo "<h2><a href='/posts/" . $row['slug'] . "'>{$row['title']}</a></h2>";
        echo $parsedown->text(urldecode($row['content']));
        echo "<small class='d-block text-right font-italic pb-2'> Published by {$row['idAuthor']}, {$row['ts']}</small>";
        echo "</div><div class='col-md-12'><hr></div></div>";
    }
    ?>
</div>

