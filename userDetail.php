<?php
// Start the session
session_start();
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Detail de l'utilisateur</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/script.js"></script>
  <style>
	#formContainer{
		max-width:400px;
	}
	
	#userDetailForm{
	}
  </style>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>
<body>
	<div id="formContainer" class="center-block">
		<div id="userDetailInfo">
			<dl id="userDetailInfo">
			  <dt><label for="email">E-mail</label></dt>
			  <dd>example@gmail.com</dd>
			</dl>
			<hr/>
			<a href="#" class="btn btn-primary btn-lg active center-block" role="button" onclick="$('#userDetailForm').show();$('#userDetailInfo').hide();">Faire des modifications</a>
		</div>
		<form id="userDetailForm">
			<div class="form-group">
				<label for="email">E-mail</label>
				<div class="input-group">
					<span class="input-group-addon">@</span>
					<input type="email" class="form-control" id="email" name="email" placeholder="Email"/>
				</div>
			</div>
			<div class="form-group">
				<label for="password">Mot de passe</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe"/>
			</div>
			<div class="form-group">
				<label for="confirmPassword">Confirmation du mot de passe</label>
				<input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirmer le mot de passe"/>
			</div>
<?php 
	if (true)//((isset($_SESSION['user']) && ($_SESSION['user'] != '')))
	{
?>
			<button type="button" class="btn btn-default pull-right" onclick="$('#userDetailForm').hide();$('#userDetailInfo').show();">Annuler</button>
			<button type="submit" class="btn btn-default pull-right">Modifier</button>
		</form>
		<script>
			$('#userDetailForm').hide();
		</script>
	</div>
<?php
	}
	else{
?>
			<button type="submit" class="btn btn-default pull-right">S'enregistrer</button>
		</form>
		<script>
			$('#userDetailInfo').empty();
		</script>
<?php
	}
?>
</body>
</html>