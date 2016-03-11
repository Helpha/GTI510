<?php
	session_start();

	include_once("db/BookReservationDB.php");
	include_once("db/BookDB.php");
	include_once("db/UserDB.php");
	
	$db = new DBHandler();
	$bookDB = new BookDB($db);
	$reservationDB = new BookReservationDB($db);
	$userDB = new UserDB($db);
	
	$reservations = Array();
	$user = NULL;
	if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['userId'])) {
		$user = $userDB->GetUser($_GET['userId']);
		$reservations = $reservationDB->GetReservationForUser($user['id']);
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
	<style>
		
	</style>
  </head>
  <body> 

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
  
  <!-- Start single page header -->
  <section id="single-page-header">
    <div class="overlay">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="single-page-header-left">
              <h2>Réservation de <?php echo $user['name']; ?></h2>
              <p>Afficher toute la liste de ses réservations</p>
            </div>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="single-page-header-right">
              <ol class="breadcrumb">
                <li><a href="index.php">Accueil</a></li>
                <li class="active">Réservations</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End single page header -->
  
  <div id="viewMainReservation" class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="service-content">
			<table class="table">
				<thead>
					<td>Livre</td>
					<td>Titre</td>
					<td>Début</td>
					<td>Fin</td>
					<td>Jours restant</td>
					<td>Terminé</td>
				</thead>
				<tbody>
              <!-- Start single service -->
			  <?php
				for($i = 0; $i < count($reservations); $i++)
				{
					$reservation = $reservations[$i];
					$book = $bookDB->GetBookById($reservation['livre_id']);
			  ?>
					<tr>
						<td><img class="image img-thumbnail img-responsive" src="<?php echo $book['Image_url'] ?>"/></td>
						<td><?php echo $book['title']; ?></td>
						<td><?php echo $reservation['date_start']; ?></td>
						<td><?php echo $reservation['date_end']; ?></td>
						<td></td>
						<td>
							<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#dialog_<?php echo $reservation['reservation_id']; ?>">X</button>
							<div id="dialog_<?php echo $reservation['reservation_id']; ?>" class="modal fade dialog" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
							  <div class="modal-dialog modal-sm">
								<div class="modal-content">
									<h4 class="service-title"/><?php echo $book['title'] ?></h4>
									<div class="center-block image">
										<img class="image img-thumbnail img-responsive" src="<?php echo $book['Image_url'] ?>"/>
									</div>
									<p>Voulez-vous retiré la réservation?</p>
									<button class="btn btn-default pull-right" onclick="$('#dialog_<?php echo $reservation['reservation_id']; ?>').modal('hide');">Annuler</button>
									<button class="btn btn-primary pull-right deleteConfirmation" data-value="<?php echo $reservation['reservation_id']; ?>">Confirmer</button>
								</div>
							  </div>
							</div>
						</td>

					</tr>
			  <?php } ?>
				</tbody>
			  </table>
              <!-- End single service -->
		</div>
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
  
 
  <!-- Custom js -->
  <script type="text/javascript" src="assets/js/custom.js"></script>
  <script>
	$('#navbar #reservationPage').addClass('active');
	
	$('.deleteConfirmation').click(function(){
		$.ajax({
        url:'reservationREST.php',
        type:'POST',
        data:{id : $(this).attr('data-value'), method : "DELETE"},
        success:function(data){
            location.reload();
        }
    });
	});
  </script>
    
  </body>
</html>


