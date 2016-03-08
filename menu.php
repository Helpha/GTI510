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
            <li><a href="index.php">Accueil</a></li>
            <li class="active"><a href="viewAllBooks.php">Livres</a></li>
            <li><a href="portfolio.html">Portfolio</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Blog <span class="fa fa-angle-down"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="blog-archive.html">Blog Archive</a></li>                
                <li><a href="blog-single-with-left-sidebar.html">Blog Single with Left Sidebar</a></li>
                <li><a href="blog-single-with-right-sidebar.html">Blog Single with Right Sidebar</a></li>
                <li><a href="blog-single-with-out-sidebar.html">Blog Single with out Sidebar</a></li>           
              </ul>
            </li>
            <li><a href="404.html">404 Page</a></li> 
			<?php if($_SESSION['user']['role'] == "admin" ){?>
				<li><a href="settings.php">Page d'administration</a></li>
			
			<?php } ?>
          </ul>                     
        </div><!--/.nav-collapse -->
		<?php } else { ?>
		
		<div id="navbar" class="navbar-collapse collapse">
          <ul id="top-menu" class="nav navbar-nav navbar-right main-nav">
            <li class="active"><a href="index.html">Accueil</a></li>
          </ul>                     
        </div><!--/.nav-collapse -->
		<?php } ?>
      </div>     
    </nav>
      </section>