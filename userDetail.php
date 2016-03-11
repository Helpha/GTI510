<?php
// Start the session
session_start();

if(!isset($_SESSION['user']))
	header("Location: index.php");
include("db/UserDB.php");

$errorMessage = Array();
$successMessage = Array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$db = new UserDB();
	$email = isset($_POST['email']) ? $_POST['email'] : $_SESSION['user']['email'];
	if($email != $_SESSION['user']['email'] && $db->UserOwnEmail($email)){
		$errorMessage[] = "Un utilisateur utilise d&eacutej&agrave ce email.";
	}
	$name = isset($_POST['username']) ? $_POST['username'] : $_SESSION['user']['name'];
	if(trim($email) == ''){
		$errorMessage[] = "Il faut un email valide";
	}
	if(trim($name) == ''){
		$errorMessage[] = "Il faut un nom valide";
	}
	$pwd = $_POST['password'];
	$cPwd = $_POST['confirmPassword'];
	if($pwd != NULL && $pwd != '' && $cPwd != NULL && $cPwd != ''){
		$errors = $db->PasswordIsValid($pwd);
		if($pwd != $cPwd){
			$errorMessage[] = 'Le mot de passe et sa confirmation ne sont pas identique.';
		}else if(count($errors) > 0){
			$errors = $db->PasswordIsValid($pwd);
			for($i = 0; $i < count($errors);$i++){
			$errorMessage[] = $errors[$i];
			}
		}else {
			$db->ChangePassword($_SESSION['user']['id'], $pwd);
			$successMessage[] = "Mot de passe modifié.";
		}
	}
	if(count($errorMessage) == 0){
			$db->UpdateUser($_SESSION['user']['id'],$email,$name, $_SESSION['user']['role'], $_SESSION['user']['isEnabled']);
			$successMessage[] = "Modification sauvegard&eacute.";
		}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>BookÉTS</title>
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/icon" href="assets/images/favicon.ico"/>
    <!-- Font Awesome -->
    <link href="assets/css/font-awesome.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">    
    <!-- Slick slider -->
    <link rel="stylesheet" type="text/css" href="assets/css/slick.css"/> 
    <!-- Fancybox slider -->
    <link rel="stylesheet" href="assets/css/jquery.fancybox.css" type="text/css" media="screen" /> 
    <!-- Animate css -->
    <link rel="stylesheet" type="text/css" href="assets/css/animate.css"/> 
    <!-- Bootstrap progressbar  --> 
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-progressbar-3.3.4.css"/> 
     <!-- Theme color -->
    <link id="switcher" href="assets/css/theme-color/default-theme.css" rel="stylesheet">

    <!-- Main Style -->
    <link href="assets/css/style.css" rel="stylesheet">
	<link href="assets/css/bookETS.css" rel="stylesheet">

    <!-- Fonts -->

    <!-- Open Sans for body font -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <!-- Lato for Title -->
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body> 
  
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>    
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <!-- Bootstrap -->
  <script src="assets/js/bootstrap.js"></script>
  <!-- Slick Slider -->
  <script type="text/javascript" src="assets/js/slick.js"></script>    
  <!-- mixit slider -->
  <script type="text/javascript" src="assets/js/jquery.mixitup.js"></script>
  <!-- Add fancyBox -->        
  <script type="text/javascript" src="assets/js/jquery.fancybox.pack.js"></script>
 <!-- counter -->
  <script src="assets/js/waypoints.js"></script>
  <script src="assets/js/jquery.counterup.js"></script>
  <!-- Wow animation -->
  <script type="text/javascript" src="assets/js/wow.js"></script> 
  <!-- progress bar   -->
  <script type="text/javascript" src="assets/js/bootstrap-progressbar.js"></script> 

  <!-- BEGAIN PRELOADER -->
  <div id="preloader">
    <div id="status">&nbsp;</div>
  </div>
  <!-- END PRELOADER -->

  <!-- SCROLL TOP BUTTON -->
  <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
  <!-- END SCROLL TOP BUTTON -->

  <!-- Start header -->
 <?php include("header.php"); ?>
  <!-- End header -->

  <!-- BEGIN MENU -->
<?php include("menu.php"); ?>

  <!-- END MENU --> 
  <style>
	</style>
  </style>
  <section id="single-page-header">
    <div class="page-header overlay">
		<div class="container">
			<h2>Profil de <?php echo $_SESSION['user']['name']; ?> </h2>
		</div>
    </div>
  </section>
  
 <div class="container">
        <div class="row">
		<?php for($i = 0; $i < count($successMessage); $i++){ ?>
			<span class="label label-success"><span><?php echo $successMessage[$i]; ?></span></span>
		<?php } for($i = 0; $i < count($errorMessage); $i++){?>
			<span class="label label-danger"><span><?php echo $errorMessage[$i]; ?></span></span>
		<?php } ?>
	<div id="formContainer" class="center-block">
		<div id="userDetailInfo">
		<?php 
			if ((isset($_SESSION['user']) && ($_SESSION['user'] != '')))
			{
		?>
			<dl>
			  <dt><label for="email">E-mail</label></dt>
			  <dd><?php echo $_SESSION['user']['email']?></dd>
			  <dt><label for="name">Name</label></dt>
			  <dd><?php echo $_SESSION['user']['name']?></dd>
			</dl>
			<hr/>
			<a href="#" class="btn btn-primary btn-lg active center-block" role="button" onclick="$('#userDetailForm').show();$('#userDetailInfo').hide();">Faire des modifications</a>
		<?php
			}
		?>
		</div>
		<form id="userDetailForm" method="POST">
			<div class="form-group">
				<label for="email">E-mail</label>
				<div class="input-group">
					<span class="input-group-addon">@</span>
					<input type="email" class="form-control" id="email" name="email" value="<?php echo $_SESSION['user']['email']; ?>"/>
				</div>
			</div>
			<div class="form-group">
				<label for="email">Nom</label>
				<div class="input-group">
					<span class="input-group-addon">abc</span>
					<input type="text" class="form-control" id="name" name="username" value="<?php echo $_SESSION['user']['name']; ?>"/>
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
	if ((isset($_SESSION['user']) && ($_SESSION['user'] != '')))
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
			$('#userDetailInfo').hide();
			$('#userDetailForm').show();
		</script>
<?php
	}
?>
</div>
</div>
      </div>
<!-- Start footer -->
  <footer id="footer">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-sm-6">
          <div class="footer-left">
            <p>Designed by <a href="http://www.markups.io/">MarkUps.io</a></p>
          </div>
        </div>
        <div class="col-md-6 col-sm-6">
          <div class="footer-right">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-google-plus"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
            <a href="#"><i class="fa fa-pinterest"></i></a>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- End footer --> 
  
 
  <!-- Custom js -->
  <script type="text/javascript" src="assets/js/custom.js"></script>
	<script>
		$('#userDetailPage').addClass('active');
	</script> 
  </body>
</html>