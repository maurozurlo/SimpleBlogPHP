<?php
require "php/_auth.php";
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
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Editor</title>
    <link
    rel="stylesheet" type="text/css" href="css/style.css">
    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <link href="/vendor/simplemde.min.css" rel="stylesheet">
  </head>

  <body>
    <div class="container">
      <div class="row my-2">
        <div class="col-md-12 mx-auto">
          <h1 class="mt-4 text-center">
            <a href="index.php">SimpleBlogPHP</a>
          </h1>
        </div>
        <div class="col-md-8 mx-auto">
          <small class="text-right d-block">
            <a class="btn btn-outline-secondary btn-sm" href="dashboard.php">Go back</a>
          </small>
        </div>
      </div>
    </div>
    <hr>

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
              <textarea id="editor"><?php echo $content ?></textarea>
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

  </body>

</html>

