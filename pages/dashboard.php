<?php
require_once("php/_protectedRoute.php");
require_once("php/_dbConfig.php");
?>


<div class="container">


  <div class="row">
    <div class="col-md-8 mx-auto">
      <div class="text-right mb-3">
        <a class="btn btn-primary" href="/editor">Create new post</a>
      </div>
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

          $sql = "SELECT id, idAuthor, state, title, ts FROM posts";
          $result = mysqli_query($con, $sql);
          while ($row = mysqli_fetch_array($result)) {
            $id = $row['id'];
            echo "<tr id='record{$id}'>";
            echo "<td scope='row'>";
            echo $id;
            echo "</td>";

            echo "<td>";
            echo $row['idAuthor'];
            echo "</td>";

            echo "<td>";
            echo $row['state'];
            echo "</td>";

            echo "<td class='title'>";
            echo $row['title'];
            echo "</td>";


            echo "<td>";
            echo $row['ts'];
            echo "</td>";

            echo "<td>";
            echo "<a class='btn btn-outline-primary actions' href='/editor/{$id}'>✏️</a>";
            echo "<a class='btn btn-outline-dark actions' style='margin-left: .5em' onclick='deletePost({$id});return false;'>❌</a>";
            echo "</td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script type="text/javascript" src="/js/dash.js"></script>

