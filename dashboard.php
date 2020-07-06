<?php
require "php/Auth.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Dashboard</title>
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script type="text/javascript" src="js/dash.js"></script>
</head>

<body>
  <div class="container">
    <div class="row my-2">
      <div class="col-md-12 mx-auto">
        <h1 class="mt-4 text-center">SimpleBlogPHP</h1>
      </div>
      <div class="col-md-8 mx-auto">
        <small class="text-right d-block">
          <a class="btn btn-outline-secondary btn-sm" href="php/logout.php">Login</a>
        </small>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row  d-flex align-items-baseline justify-content-around">
      <div class="col-4">
        <p href="">
          <?php echo "Hi " . $_SESSION["name"]; ?>
          <div id="resultado"></div>
        </p>
      </div>
      <div class="col-8 d-flex justify-content-end">
        <a class="btn btn-primary" href="editor.php">Create new post</a>
      </div>
    </div>
    <div class="row">
      <table class="table">
        <thead>
          <tr>
            <th scope="col">id</th>
            <th scope="col">Author</th>
            <th scope="col">Status</th>
            <th scope="col">Title</th>
            <th scope="col">Date</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          require_once("php/dbConfig.php");
          $sql = "SELECT id, idAuthor, state, title, ts FROM posts";
          $result = mysqli_query($con, $sql);
          while ($row = mysqli_fetch_array($result)) {
            $id = $row['id'];
            echo "<tr id='registro{$id}'>";
            echo "<td scope='row'>";
            echo $id;
            echo "</td>";

            echo "<td>";
            echo $row['idAuthor'];
            echo "</td>";

            echo "<td>";
            echo $row['state'];
            echo "</td>";

            echo "<td>";
            echo $row['title'];
            echo "</td>";


            echo "<td>";
            echo $row['ts'];
            echo "</td>";

            echo "<td>";
            echo "<a class='btn btn-info' href='editor.php?id={$id}' style='color:white;'><i class='fas fa-edit'></i></a>";
            echo "<a class='btn btn-danger' style='margin-left: .5em;color:white' onclick='deletePost({$id});return false;'><i class='fas fa-trash-alt'></i></a>";
            echo "</td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- /.container -->
</body>

</html>