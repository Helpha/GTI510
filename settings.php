<?php
	session_start();
	if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != "admin"){
		header("Location: index.php");
	}
	
	include_once('connect.php');
	include_once('db/UserDB.php');
	include_once('db/GenericDB.php');
	
	$db = new DBHandler();
	$userDB = new UserDB($db);
	$genericDB = new GenericDB($db);
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$_SESSION['settings']['SystemMessage'] = $_POST['generalMessage'];
		$_SESSION['settings']['MaxReservationCount'] = $_POST['maxRCount'];
		$genericDB->PersistSettings();
	}

	$genericDB->GetSettings();
	$users = $userDB->GetAllUsers();
?>
<!DOCTYPE>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
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
		.btn-success > span::before{
			content:"Activé";
		}
		
		.btn-danger > span::before{
			content:"Désactivé";
		}
		
		#usersAdminView .btn{
			min-width: 100px;
			margin-top: 10px;
		}
		.overlay{
			padding:20px;
		}
	</style>
	  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
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
    <div class="page-header overlay">
		<div class="container">
			<h2>Page d'administration </h2>
		</div>
    </div>
  </section>
  <!-- End single page header -->
  
  <!-- Start Service -->
  <div class="container">
          <div class="col-md-8 col-sm-8 col-xs-12">
            <div>
				<table id="usersAdminView" class="table">
					<thead>
						<tr>
							<th>Nom</th>
							<th>Email</th>
							<th>Reservations</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php
							for($i = 0; $i < count($users); $i++)
							{
								$userId = $users[$i]['id']; 
								$isEnable = $users[$i]['isEnabled'] == 1;
						?>
								<tr>
									<td><?php echo $users[$i]['name']; ?></td>
									<td><?php echo $users[$i]['email']; ?></td>
									<td></td>
									<td id="user_row_<?php echo $userId ?>">
										<button name="action" value="disable" class="btn <?php echo ($isEnable == 1 ? 'btn-success' : 'btn-danger') ?>" data-value="<?php echo ($isEnable ? 0 : 1); ?>" onclick="isEnable(<?php echo $userId ?>, this);"><span></span></button>
									</td>
								</tr>
						<?php
							}
						?>
					</tbody>
				</table>
            </div>
          </div>
          <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="single-page-header-right">
              <form METHOD="POST">
				<div class="form-group">
					<label for="email">Nombre maximum de réservations par utilisateur</label>
					<div>
						<input type="number" id="maxRCount" min=<?php echo $_SESSION['settings']['minMaxReservationCount']; ?> max=<?php echo $_SESSION['settings']['maxMaxReservationCount']; ?> class="form-control" name="maxRCount" value="<?php echo $_SESSION['settings']['MaxReservationCount'];?>"/>
					</div>
				</div>
				<div class="form-group">
					<label for="email">Message du jour</label>
					<div>
						<textarea type="text" min="0" class="form-control" id="generalMessage" name="generalMessage"><?php echo $_SESSION['settings']['SystemMessage']; ?></textarea>
					</div>
				</div>
				<button type="submit">Enregistrer</button>
			</form>
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
    <script type="text/javascript">
  <!-- End single page header -->
	function isEnable(id, obj){
		$.ajax({
        url:'userActivation.php',
        type:'post',
        data:{user : id, action : $(obj).attr("data-value")},
        success:function(data){
            if($(obj).hasClass('btn-success')){
				$(obj).removeClass('btn-success').addClass('btn-danger');
				$(obj).attr("data-value","1");
			}
			else{
				$(obj).removeClass('btn-danger').addClass('btn-success');
				$(obj).attr("data-value","0");
			}
        }
    });
	}
	
	$( "#maxRCount" ).change(function() {
      var max = parseInt($(this).attr('max'));
      var min = parseInt($(this).attr('min'));
      if ($(this).val() > max)
      {
          $(this).val(max);
      }
      else if ($(this).val() < min)
      {
          $(this).val(min);
      }       
    }); 
  </script>
  </body>
</html>
    
  </body>
</html>