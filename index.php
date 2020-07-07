<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="ElMiauro">

  <title>SimpleBlogPHP</title>
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
</head>

<body>
  <div class="container">
    <div class="row my-2">
      <div class="col-md-12 mx-auto">
        <h1 class="mt-4 text-center"><a href="index.php">SimpleBlogPHP</a></h1>
      </div>
      <div class="col-md-8 mx-auto">
        <small class="text-right d-block">
          <a class="btn btn-outline-secondary btn-sm" href="login.php">Login</a>
        </small>
      </div>
    </div>
  </div>
  <hr>

  <div class="container">
    <?php
    require_once("php/_dbConfig.php");
    $sql = 'SELECT id, idAuthor, title, content, ts FROM posts where state = "Published"  ORDER BY ts DESC';
    $result = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($result)) {
      $str = urldecode($row['content']);
      echo "<div class='row'><div class='col-md-8 mx-auto'>";
      echo "<h2>{$row['title']}</h2>";
      echo "<p>{$str}</p>";
      echo "<small class='d-block text-right font-italic pb-2'> Published by {$row['idAuthor']}, {$row['ts']}</small>";
      echo "</div><div class='col-md-12'><hr></div></div>";
    }
    ?>

  </div>
  <!-- /.container -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
</body>

</html>
