  <section id="menu-area">      
    <nav class="navbar navbar-default" role="navigation">  
      <div class="container">
        <div class="navbar-header">
          <!-- FOR MOBILE VIEW COLLAPSED BUTTON -->
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!-- LOGO -->              
          <!-- TEXT BASED LOGO -->
          <a class="navbar-brand" href="index.php">Book&eacute;TS</a>              
          <!-- IMG BASED LOGO  -->
         <!-- <a class="navbar-brand" href="indes.php"><img src="assets/images/logo.png" alt="logo"></a> -->                    
        </div>
		<?php if(isset($_SESSION['user'])){ ?>
        <div id="navbar" class="navbar-collapse collapse">
          <ul id="top-menu" class="nav navbar-nav navbar-right main-nav">
            <li id="homePage"><a href="index.php">Accueil</a></li>
            <li id="booksPage"><a href="viewAllBooks.php">Livres</a></li>
			<li id="reservationPage"><a href="viewAllReservation.php?userId=<?php echo $_SESSION['user']['id']; ?>">Voir vos R&eacuteservations</a></li>
			<?php if($_SESSION['user']['role'] == "admin" ){?>
				<li id="adminPage"><a href="settings.php">Page d'administration</a></li>
			
			<?php } ?>
          </ul>                     
        </div><!--/.nav-collapse -->
		<?php } else { ?>
		
		<div id="navbar" class="navbar-collapse collapse">
          <ul id="top-menu" class="nav navbar-nav navbar-right main-nav">
            <li class="active"><a href="index.php">Accueil</a></li>
          </ul>                     
        </div><!--/.nav-collapse -->
		<?php } ?>
      </div>     
    </nav>
      </section>