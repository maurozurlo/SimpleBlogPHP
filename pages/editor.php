<?php
require_once("php/_protectedRoute.php");
require_once("php/_dbConfig.php");

$id = "";
$title = $state = $content = $ts = '';
$action = "";
if (isset($_GET["id"])) {
  // Load post for editing
  $id = htmlspecialchars($_GET["id"]);
  $sql = "SELECT state, title, content, ts FROM posts WHERE id = {$id}";
  if ($result = mysqli_query($con, $sql)) {
    while ($row = mysqli_fetch_array($result)) {
      $title = $row['title'];
      $state = $row['state'];
      $content = $row['content'];
      $ts = $row['ts'];
    }
    // Free result set
    $action = "update";
    mysqli_free_result($result);
  }
} else {
  // Invalid GET or no data found
  $action = "create";
}

function selectFn($val)
{
  global $state;
  return $val == $state ? "selected" : "";
}
?>

<div class="container">
  <div class="row">
    <div class="col-md-8 mx-auto">
      <form id="postForm">
        <input type="hidden" value="<?php echo $id ?>" id="id">
        <input type="hidden" id="action" value="<?php echo $action ?>">
        <div class="form-group">
          <input type="text" class="form-control" id="title" placeholder="Title..." value="<?php echo $title ?>" required>
        </div>
        <div class="form-group">
          <label for="date">Date</label>
          <input type="datetime-local" class="form-control" id="date" value="<?php echo $ts ?>">
        </div>
        <div class="form-group">
          <label for="state">Status</label>
          <select class="form-control" id="state">
            <option <?php echo selectFn("Published") ?>>Published</option>
            <option <?php echo selectFn("Draft") ?>>Draft</option>
          </select>
        </div>
        <div class="form-group" style="min-height:380px">
          <textarea id="editor"><?php echo urldecode($content) ?></textarea>
        </div>
        <div class="form-group float-right">
          <button class="btn btn-outline-danger" onclick="deletePost();return false;">Delete</button>
          <button class="btn btn-primary" id="submit" type="button">Save</button>
        </div>
      </form>
      <div id="result"></div>
    </div>
  </div>
</div>

<!-- Include the Quill library -->
<script src="/vendor/simplemde.min.js"></script>
<script type="text/javascript" src="js/editor.js"></script>

