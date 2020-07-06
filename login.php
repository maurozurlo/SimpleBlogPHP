<!DOCTYPE html>
<html>

<head>
	<title>Login Page</title>
	<meta charset="utf-8">
	<meta name="description" content="">
	<!-- Mobile-friendly viewport -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Style sheet link -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
</head>

<body>
<div class="container">
    <div class="row my-2">
      <div class="col-md-12 mx-auto">
        <h1 class="mt-4 text-center">SimpleBlogPHP</h1>
      </div>
      <div class="col-md-8 mx-auto">
        <small class="text-right d-block">
          <a class="btn btn-outline-secondary btn-sm" href="index.php">Go back</a>
        </small>
      </div>
    </div>
  </div>
  <hr>
	<div class="container">
		<div class="col-md-8 mx-auto">
			<form>
				<div class="form-group">
					<label for="user">User:</label><br>
					<input class="form-control" type="text" id="user" name="user">
				</div>
				<div class="form-group">
					<label for="pass">Password:</label><br>
					<input class="form-control" type="password" id="pass" name="pass">
				</div>
				<div class="form-group">
					<button class="btn btn-primary" onclick="login()">Log in</button>
				</div>
			</form>
			<div id="loading"></div>
			<div id="error" style="display: none; color:red;">
				Wrong credentials.
			</div>
		</div>

	</div>

</body>

</html>