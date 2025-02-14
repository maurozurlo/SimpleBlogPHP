<?php
require_once "php/_protectedRoute.php";
require_once "php/_dbConfig.php";

$id = $username = "";
$action = "";
if (isset($params["id"])) {
    // Load user for editing
    $id = htmlspecialchars($params["id"]);
    $sql = "SELECT username FROM users WHERE id = {$id}";
    if ($result = mysqli_query($con, $sql)) {
        while ($row = mysqli_fetch_array($result)) {
            $username = $row['username'];
        }
        $action = "update";
        mysqli_free_result($result);
    }
} else {
    // Invalid GET or no data found
    $action = "create";
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <form id="userForm">
                <input type="hidden" value="<?php echo $id ?>" id="id">
                <input type="hidden" id="action" value="<?php echo $action ?>">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" placeholder="Enter username" value="<?php echo $username ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                    type="password" class="form-control" id="password" placeholder="Enter password" <?php echo $action === "create" ? "required" : ""; ?>>
                    <?php if ($action === "update"): ?>
                        <small class="form-text text-muted">Leave blank to keep the current password.</small>
                    <?php endif; ?>
                </div>
                <div
                    class="form-group float-right">
                    <?php if ($action === "update"): ?>
                        <button class="btn btn-outline-danger" onclick="deleteUser();return false;">Delete</button>
                    <?php endif; ?>
                    <button class="btn btn-primary" id="submit" type="button">Save</button>
                </div>
            </form>
            <div id="result"></div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/js/backoffice/users-edit.js"></script>

