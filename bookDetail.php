<?php
	session_start();
	include_once('db/BookDB.php');
	include_once('db/BookReservationDB.php');
	
	$db = new DBHandler();
	$bookDB = new BookDB($db);
	$reserveDB = new BookReservationDB($db);
	$book = NULL;
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$title = $_POST['title'];
		$description = $_POST['description'];
		$Image_Url = $_POST['imageUrl'];
		$date_publish = $_POST['date'];
		$count = $_POST['count'];
		$author = $_POST['author'];
		$isbn = $_POST['isbn'];
      
		if(isset($_POST['bookId'])){
			$bookDB->UpdateBook($_POST['bookId'], $isbn, $title, $description, $Image_Url, $author, $date_publish, $count);
			$book = $bookDB->GetBookById($_POST['bookId']);
         } else {
			$bookDB->AddBook($isbn, $title, $description, $Image_Url, $author, $date_publish, $count);
			header("Location: viewAllBooks.php");
      }
		
      } else if($_SERVER['REQUEST_METHOD'] === 'GET') {
		if(isset($_GET['isbn'])) {
			$result = $bookDB->GetBookByISBN($_GET['isbn']);
			if(count($result) > 0 ){
				$book = $result;
         }
      }
		
		if($book == NULL){
			if(isset($_SESSION['user']) && $_SESSION['user']['role'] == "admin"){
            
            }else{
				header("Location: index.php");
         }
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
      <title>Book&Eacute;TS</title>
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
      
      <!-- jQuery library -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
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
                        <h2><?php  if($book != NULL) {?> Détail sur <i><?php echo $book['title']?></i><?php }else{ ?> Ajout d'un livre <?php } ?> </h2>
                     </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <div class="single-page-header-right">
                        <ol class="breadcrumb">
                           <li><a href="index.php">Accueil</a></li>
                           <li><a href="viewAllBooks.php">Livres</a></li>
                           <li class="active">Détail</li>
                        </ol>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- End single page header -->
      <style>
         .bookDetail{
         margin-top: 260px;
         margin-bottom: 60px;
         }
         .bookDetail > div > dl{
         margin-top:5%;
         }
         
         .bookImageContainer > img{
         max-width:90%;
         max-height:90%;
         display:block;
         margin-left:auto;
         margin-right:auto;
         margin-top:5%;
         margin-bottom:5%;
         }
      </style>
      <!-- Start Service -->
      <div class="container">
         <div class="bookDetail">
            <?php if($book != NULL) { ?>
               <div id="bookDetailInfo">
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <div class="bookImageContainer">
                        <img class="img-rounded img-responsive" src="<?php echo $book['Image_url']; ?>" />
                     </div>
                  </div>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                     <?php if($_SESSION['user']['role'] == "admin") { ?>
                        <a href="#" class="btn btn-primary btn-lg active center-block" role="button" onclick="$('#bookDetailForm').show();$('#bookDetailInfo').hide();">Faire des modifications</a>
                     <?php } ?>
                     <dl>
                        <dt><label for="title">Titre</label></dt>
                        <dd><?php echo $book['title']?></dd>
                        <dt><label for="isbn">Num&eacute;ro international normalis&eacute; du livre (ISBN)</label></dt>
                        <dd><?php echo $book['isbn']?></dd>
                        <dt><label for="description">Description sommaire</label></dt>
                        <dd><?php echo $book['description']?></dd>
                        <dt><label for="author">Auteur</label></dt>
                        <dd><?php echo $book['author']?></dd>
                        <dt><label for="date_publish">Date de publication</label></dt>
                        <dd><?php echo $book['date_publish']?></dd>
                        <dt><label for="count">Nombre d'exemplaire total</label></dt>
                        <dd><?php echo $book['Count']?></dd>
                        <dt><label for="freeToReserve">Nombre d'exemplaire disponible</label></dt>
                        <dd><?php 
                           $reservations = $reserveDB->GetReservationsForBook($book['livre_id']);  
                        echo ($book['Count'] - count($reservations)); ?></dd>
                     </dl>
                     <?php if($book['Count'] - count($reservations) > 0 ) { ?>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#dialog_<?php echo $book['livre_id']; ?>">Faire une réservation</button>
                        <div id="dialog_<?php echo $book['livre_id']; ?>" class="modal fade dialog" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                           <div class="modal-dialog modal-sm">
                              <div class="modal-content">
                                 <form id="reservationForm" method="POST" action="reservationRest.php">
                                    <input type="hidden" name="method" value="PUT"/>
                                    <input type="hidden" name="bookId" value="<?php echo $book['livre_id']; ?>"/>
                                    <input type="hidden" name="userId" value="<?php echo $_SESSION['user']['id']; ?>"/>
                                    <!--<div class="form-group">
                                       <label for="date_publish">Date de publication</label>
                                       <div class="input-group">
                                       <input type="date" class="form-control" id="date" name="date"/>
                                       </div>
                                    </div>-->
                                    <div class="form-group">
                                       <select class="form-control" id="reservationLength" name="reservationLength">
                                          <option value="7 day">7 jours</option>
                                          <option value="14 day">14 jours</option>
                                          <option value="1 month">1 mois</option>
                                       </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Réserver</button>
                                 </form>
                              </div>
                           </div>
                        </div>
                     <?php } ?>
                  </div>
               </div>
            <?php } ?>
            
            <form id="bookDetailForm" method="POST">
               <?php if($book != NULL) { ?><input type="hidden" name="bookId" value="<?php echo $book['livre_id']; ?>" /> <?php } ?>
               <div class="form-group">
                  <label for="title">Titre</label>
                  <div class="input-group">
                     <span class="input-group-addon">abc</span>
                     <input type="text" class="form-control" id="title" name="title" value="<?php echo $book['title']; ?>"/>
                  </div>
               </div>
               <div class="form-group">
                  <label for="title">Url de l'image représentative</label>
                  <div class="input-group">
                     <span class="input-group-addon">abc</span>
                     <input type="text" class="form-control" id="imageUrl" name="imageUrl" value="<?php echo $book['Image_url']; ?>"/>
                  </div>
               </div>
               <div class="form-group">
                  <label for="isbn">Num&eacute;ro international normalis&eacute; du livre (ISBN)</label>
                  <div class="input-group">
                     <span class="input-group-addon">abc</span>
                     <input type="text" class="form-control" id="name" name="isbn" value="<?php echo $book['isbn'] ?>"/>
                  </div>
               </div>
               <div class="form-group">
                  <label for="description">Description sommaire</label>
                  <div class="input-group">
                     <span class="input-group-addon">abc</span>
                     <textarea type="text" class="form-control" id="description" name="description"><?php echo $book['description']; ?></textarea>
                  </div>
               </div>
               <div class="form-group">
                  <label for="author">Auteur</label>
                  <div class="input-group">
                     <span class="input-group-addon">abc</span>
                     <input type="text" class="form-control" id="author" name="author" value="<?php echo $book['author']; ?>"/>
                  </div>
               </div>
               <div class="form-group">
                  <label for="date_publish">Date de publication</label>
                  <div class="input-group">
                     <input type="date" class="form-control" id="date" name="date" value="<?php echo $book['date_publish']; ?>"/>
                  </div>
               </div>
               <div class="form-group">
                  <label for="count">Nombre d'exemplaire</label>
                  <div class="input-group">
                     <input type="number" class="form-control" id="count" name="count" min="0" value="<?php echo $book['Count']; ?>"/>
                  </div>
               </div>
               <?php 
                  if ($book != NULL)
                  {
                  ?>
                  <button type="button" class="btn btn-default pull-right" onclick="$('#bookDetailForm').hide();$('#bookDetailInfo').show();">Annuler</button>
                  <button type="submit" class="btn btn-default pull-right">Sauvegarder</button>
               </form>
               <script>
                  $('#bookDetailForm').hide();
               </script>
               <?php
               }
               else{
               ?>
               <button type="submit" class="btn btn-default pull-right">Sauvegarder</button>
            </form>
            <script>
               $('#bookDetailInfo').hide();
               $('#bookDetailForm').show();
            </script>
            <?php
            }
         ?>
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
    </div>
  </section>
  <!-- End single page header -->


	</div>
  </div>
  


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
   <script>
      $( "#count" ).change(function() {
         //var max = parseInt($(this).attr('max'));
         var min = parseInt($(this).attr('min'));
         /*if ($(this).val() > max)
            {
            $(this).val(max);
         }*/
         if ($(this).val() < min)
         {
            $(this).val(min);
         }       
      }); 
      
      $('#reservationForm').submit( function() {            
         $.ajax({
            url     : $(this).attr('action'),
            type    : $(this).attr('method'),
            data    : $(this).serialize(),
            success : function( data ) {
               $('#reservationForm').html(data);
               setTimeout(function(){location.reload();},500);
            },
            error   : function( xhr, err ) {
               $
            }
         });    
         return false;
      });
      //$('#date').attr("min", (new Date()).toISOString().slice(0,10));
      
      $('#navbar #booksPage').addClass('active');
   </script>
   
</body>
</html>