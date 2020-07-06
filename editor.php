<?php
require "php/Auth.php";
require_once("php/dbConfig.php");
$id = "";
$title = $state = $content = $ts = '';
$action = "nuevo";
if (isset($_GET["id"])) {
  //Cargar segun el get
  $id = htmlspecialchars($_GET["id"]);
  $sql = "SELECT state, title, content, ts FROM posts where id = {$id}";
  if ($result = mysqli_query($con, $sql)) {
    while ($row = mysqli_fetch_array($result)) {
      $title = $row['title'];
      $state = $row['state'];
      $content = $row['content'];
      $ts = $row['ts'];
    }
    // Free result set
    $action = "actualiza";
    mysqli_free_result($result);
  } else {
    //no habia get/get invalido
    $action = "nuevo";
  }
}

function selectFn($val)
{
  global $state;
  if ($val == $state) {
    return "selected";
  } else {
    return "";
  }
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
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="js/editor.js"></script>
</head>

<body>
  <div class="container">
  <div class="row my-2">
      <div class="col-md-12 mx-auto">
        <h1 class="mt-4 text-center">SimpleBlogPHP</h1>
      </div>
      <div class="col-md-8 mx-auto">
        <small class="text-right d-block">
          <a class="btn btn-outline-secondary btn-sm" href="dashboard.php">Go back</a>
        </small>
      </div>
    </div>
  </div>
    <div class="row">
      <div class="col-md-8">
        <form>
          <input type="hidden" value="<?php echo $id ?>" id="id">
          <input type="hidden" id="action" value="<?php echo $action ?>">
          <div class="form-group">
            <input type="text" class="form-control" id="title" placeholder="Title..." value="<?php echo $title ?>" required>
          </div>
          <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" value="<?php echo $ts ?>">
          </div>
          <div class="form-group">
            <label for="state">Status</label>
            <select class="form-control" id="state">
              <option <?php echo selectFn("Publicado") ?>>Published</option>
              <option <?php echo selectFn("Borrador") ?>>Draft</option>
            </select>
          </div>
          <div class="form-group">
            <textarea class="form-control" id="content" rows="3" placeholder="Write something..."><?php echo $content ?></textarea>
          </div>
          <div class="form-group float-right">
            <a class="btn btn-danger" onclick="deletePost();return false;">Delete</a>
            <a class="btn btn-primary" onclick="realizaProceso($('#action').val());return false;">Save</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- /.container -->
</body>

</html>