<?php
	/*include_once('connect.php');
	include_once('db/UserDB.php');
	/*if(!isset($_SESSION['user']))
		header("Location: index.php");*/
	/*$db = new DBHandler();
	$userDB = new UserDB($db);
	
	$users = $userDB->GetAllUsers();*/
	$users = array();
	array_push($users,array(
	"id" => 0,
    "email" => "exemple@gmail.com",
    "name" => "exemple",
	"isEnabled" => 0
	));
?>
<!DOCTYPE>
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
		
		#usersAdminView{
			width:100%;
			color:white;
		}
		
		#usersAdminView .btn{
			min-width: 100px;
			margin-top: 10px;
		}
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
        <div>
          <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="single-page-header-left">
				<table id="usersAdminView">
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
								$isEnable = $users[$i]['isEnabled'];
						?>
								<tr>
									<td><?php echo $users[$i]['name']; ?></td>
									<td><?php echo $users[$i]['email']; ?></td>
									<td></td>
									<td id="user_row_<?php echo $userId ?>">
										<button type="submit" name="action" value="disable" class="btn <?php echo ($isEnable == 1 ? 'btn-success' : 'btn-danger') ?>" onclick="isEnable(<?php echo $userId . ',' . ($isEnable ? 1 : 0); ?>, this);"><span></span></button>
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
              <form>
				<div class="form-group">
					<label for="email">Nombre maximum de réservations par utilisateur</label>
					<div class="input-group">
						<input type="number" min="0" class="form-control" id="maxReservationCount" name="maxReservationCount" placeholder=""/>
					</div>
					<label for="email">Message du jour</label>
					<div class="input-group">
						<textarea type="number" min="0" class="form-control" id="generalMessage" name="generalMessage" placeholder=""></textarea>
					</div>
				</div>
			</form>
            </div>
          </div>
		</div>
      </div>
    </div>
  </section>
  <!-- End single page header -->
  
  <!-- Start Service -->
  

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
  <script type="text/javascript">
	function isEnable(id, action, obj){
		$.ajax({
        url:'userActivation.php',
        type:'post',
        data:{id : id, action : action},
        success:function(){
            if($(obj).hasClass('btn-success')){
				$(obj).removeClass('btn-success').addClass('btn-danger');
			}
			else{
				$(obj).removeClass('btn-danger').addClass('btn-success');
			}
        }
    });
	}
  </script>
    
  </body>
</html>