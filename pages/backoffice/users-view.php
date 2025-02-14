<div class="text-right mb-3">
    <a class="btn btn-primary" href="/editor/users/">Create new user</a>
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Username</th>
            <th scope="col">Created At</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        require_once("./php/_dbConfig.php");

        $sql = "SELECT id, username, timestamp FROM users";
        $result = mysqli_query($con, $sql);

        while ($row = mysqli_fetch_array($result)) {
            $id = $row['id'];
            echo "<tr id='record{$id}'>";
            echo "<td scope='row'>{$id}</td>";
            echo "<td>{$row['username']}</td>";
            echo "<td>{$row['timestamp']}</td>";
            echo "<td>";
            echo "<a class='btn btn-outline-primary actions' href='/editor/users/{$id}'>✏️</a>";
            echo "<a class='btn btn-outline-dark actions' style='margin-left: .5em' onclick='deleteUser({$id});return false;'>❌</a>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

<script type="text/javascript" src="/js/backoffice/users-view.js"></script>

