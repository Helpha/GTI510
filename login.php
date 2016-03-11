<?php
// Start the session
session_start();
?>
<!doctype html>
<html lang="fr">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>Connection</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/script.js"></script>
  <style>
	#formContainer{
		max-width:300px;
	}
  </style>
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>
<body>
<?php 
	if ((isset($_SESSION['user']) && ($_SESSION['user'] != '')))
	{
	
	echo "Welcome";
?>

<?php
	}
	else{
?>
	<div id="formContainer" class="center-block">
		<form action="login.php" method="POST" class="center-block">
			<div class="form-group">
				<label for="email">Email address</label>
				<div class="input-group">
					<span class="input-group-addon">@</span>
					<input type="email" class="form-control" id="email" name="email" placeholder="Email"/>
				</div>
			  </div>
			  <div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="Password">
			  </div>
			  <button type="submit" class="btn btn-default center-block">Se connecter</button>
		</form>
		<hr/>
		<a href="#" class="btn btn-primary btn-lg active center-block" role="button">Vous n'avez pas de compte ?</a>
	</div>
<?php
	}
?>
</body>
</html>