<?php
	session_start();

	include_once("db/BookDB.php");
	
	$bookDB = new BookDB();
	$books = Array();
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$books = $bookDB->GetAllBooks($_POST['searchType'], $_POST['searchType'], $_POST['search']);
	} else {
		$books = $bookDB->GetAllBooks('title');
	}
?>

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
              <h2>Tous nos livres</h2>
              <p>Afficher toute la liste de nos livres</p>
            </div>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="single-page-header-right">
              <ol class="breadcrumb">
                <li><a href="index.php">Accueil</a></li>
                <li class="active">Livres</li>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End single page header -->
  
  <div id="viewMainBooks" class="container">
	<div id="booksHeader">
		<div class="col-md-6 col-sm-6 col-xs-12">
			<form id="searchForm" class="form-inline" METHOD="POST">
				<div class="form-group">
				  <select class="form-control" id="searchType" name="searchType">
					<option value="title">Titre</option>
					<option value="author">Auteur</option>
					<option value="isbn">ISBN</option>
				  </select>
				</div>
				<div class="form-group" id="search">
					<input type="text" style="color: black;" placeholder="Rechercher par auteur, titre ou ISBN" name="search" id="m_search" style="display: inline-block;">
				</div>
			  <button type="submit" class="btn btn-default">
				<i class="fa fa-search"></i>
			  </button>
			</form>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12">
			<?php if($_SESSION['user']['role'] == "admin") { ?>
				<a href="bookDetail.php" id="addBook" class="btn btn-primary btn-lg active center-block" > Ajouter un nouveau livre</a>
			<?php } ?>
		</div>
	</div>
      <div class="row">
        <div class="col-md-12">
          <div class="service-content">
              <!-- Start single service -->
			  <?php
				for($i = 0; $i < count($books); $i++)
				{
					$book = $books[$i];
			  ?>
              <div class="col-md-12">
                <div class="single-service wow zoomIn">
                  <img class="image img-thumbnail img-responsive" src="<?php echo $book['Image_url'] ?>" style="float: left"/>
                 
                  <div style="float: left">
				  <!--
                 <div style="float: right"><a href="viewAllBooks.php?action=res&id=82821">Réserver</a> &nbsp;<a href="viewAllBooks.php?action=edit&id=82821">Modifier</a> &nbsp; <a href="viewAllBooks.php?action=del&id=82821">Supprimer</a></div>
                  -->
				  <a href="bookDetail.php?isbn=<?php echo $book['isbn'];?>"<h4 class="service-title"/><?php echo $book['title'] ?></h4></a>
                  <p>Écrit par : <?php echo $book['author'] ?></p>
                  <p>ISBN : <?php echo $book['isbn'] ?></p>
                  <p>Date d'édition : <?php echo $book['date_publish'] ?></p>
                  <p><?php echo $book['description'] ?></p>
                  </div>
                </div>
              </div>
			  <?php } ?>
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
	$('#navbar #booksPage').addClass('active');
  </script>
    
  </body>
</html>


