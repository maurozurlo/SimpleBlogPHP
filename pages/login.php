<div class="container">
	<div class="row my-2">
		<div class="col-md-12 mx-auto">
			<h1 class="mt-4 text-center">
				<a href="/">SimpleBlogPHP</a>
			</h1>
		</div>
		<div class="col-md-8 mx-auto">
			<small class="text-right d-block">
				<a class="btn btn-outline-secondary btn-sm" href="/">Go back</a>
			</small>
		</div>
	</div>
</div>
<hr>
<div class="container">
	<div class="col-md-8 mx-auto">
		<div class="form-group">
			<label for="user">User:</label><br>
			<input class="form-control" type="text" id="user" name="user" value="admin">
		</div>
		<div class="form-group">
			<label for="pass">Password:</label><br>
			<input class="form-control" type="password" id="pass" name="pass" value="admin">
		</div>
		<div class="form-group">
			<button class="btn btn-primary" id="loginBtn">Log in</button>
		</div>
		<div id="result"></div>
	</div>
</div>
<script src="/js/login.js"></script>

