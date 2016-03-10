<style>
	.login.active{
		background-color:#2bcdc1;
	}
</style>
<header id="header">
    <!-- header top search -->
    <div class="header-top">
      <div class="container">
        <form action="">
          <div id="search">
          <input type="text" placeholder="Type your search keyword here and hit Enter..." name="s" id="m_search" style="display: inline-block;">
          <button type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
        </form>
      </div>
    </div>
    <!-- header bottom -->
    <div class="header-bottom">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-sm-6 col-xs-6">
            <!--<div class="header-contact">
              <ul>
                <li>
                  <div class="phone">
                    <i class="fa fa-phone"></i>
                    +1(800) 699-7071
                  </div>
                </li>
                <li>
                  <div class="mail">
                    <i class="fa fa-envelope"></i>
                    contact@bookets.com
                  </div>
                </li>
              </ul>
            </div>-->
          </div>
          <div class="col-md-6 col-sm-6 col-xs-6">
            <div class="header-login">
			<?php if(isset($_SESSION['user']) && isset($_SESSION['user']['name'])){ ?>
				<div class="">
					<a class="login modal-form" id="userDetailPage" href="userDetail.php"><?php echo $_SESSION['user']['name']; ?></a>
					<a class="login modal-form" href="signout.php">Se d&eacute;connecter</a>
				  </ul>
				</div>
			<?php } else { ?>			  
				<a class="login modal-form" id="loginLink" data-target="#login-form" data-toggle="modal" href="#">Connexion / S'enregistrer</a>
			<?php } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  
  <!-- Start login modal window -->
  <div aria-hidden="false" role="dialog" tabindex="-1" id="login-form" class="modal leread-modal fade in">
    <div class="modal-dialog">
      <!-- Start login section -->
      <div id="login-content" class="modal-content">
        <div class="modal-header">
          <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><i class="fa fa-unlock-alt"></i>Connexion</h4>
        </div>
        <div class="modal-body">
          <form id="signinForm" action="signin.php" method="POST">
		    <div class="form-group">
				<span class="label status"></span>
			</div>
            <div class="form-group">
              <input type="text" name ="email" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input type="password" name="pwd" placeholder="Mot de passe" class="form-control">
            </div>
             <div class="loginbox">
              <!--<label><input type="checkbox"><span>Remember me</span></label>-->
              <button class="btn signin-btn" type="submit">Se connecter</button>
            </div>                    
          </form>
        </div>
        <div class="modal-footer footer-box">
          <!--<a href="#">Forgot password ?</a>-->
          <span>Désirez vous un compte ? <a id="signup-btn" href="#">S'enregistrer</a></span>            
        </div>
      </div>
      <!-- Start signup section -->
      <div id="signup-content" class="modal-content">
        <div class="modal-header">
          <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><i class="fa fa-lock"></i>Enregistrer</h4>
        </div>
        <div class="modal-body">
          <form id="signupForm" action="signup.php" method="POST">
			  <div class="form-group">
				<span class="label status"></span>
			  </div>
			<div class="form-group">
              <input name ="email" placeholder="Email" class="form-control">
            </div>
            <div class="form-group">
              <input name="name" placeholder="Nom" class="form-control">
            </div>
            <!--<div class="form-group">
              <input placeholder="Username" class="form-control">
            </div>-->
            <div class="form-group">
              <input type="password" name="pwd" placeholder="Mot de passe" class="form-control">
            </div>
			<div class="form-group">
              <input type="password" name="confirmPwd" placeholder="Confirmation de mot de passe" class="form-control">
            </div>
            <div class="signupbox">
              <span>Vous avez déjà un compte? <a id="login-btn" href="#">Se connecter.</a></span>
            </div>
            <div class="loginbox">
              <!--<label><input type="checkbox"><span>Remember me</span><i class="fa"></i></label>-->
              <button class="btn signin-btn" type="submit">Enregistrer</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- End login modal window -->
  
    <script type="text/javascript">
	$('#signinForm').submit( function() {  
		var form = this;
		
        $.ajax({
            url     : $(this).attr('action'),
            type    : $(this).attr('method'),
            data    : $(this).serialize(),
            success : function( data ) {
						var jsonResult = JSON.parse(data);
						$('#signinForm .status').removeClass('label-success').removeClass('label-danger').addClass('label-'+jsonResult["status"]).html("<span>"+jsonResult["message"]+"</span>");						
						if(jsonResult["status"] == "success")
							setTimeout(function(){location.reload();},500);
					  },
            error   : function( xhr, err ) {
							$('#signinForm .status').html(xhr);
                            alert(err);
                      }
        });    
        return false;
    });
	$('#signupForm').submit( function() {            
        $.ajax({
            url     : $(this).attr('action'),
            type    : $(this).attr('method'),
            data    : $(this).serialize(),
            success : function( data ) {
                        var jsonResult = JSON.parse(data);
						$('#signupForm .status').removeClass('label-success').removeClass('label-danger').addClass('label-'+jsonResult["status"]).html("<span>"+jsonResult["message"]+"</span>");
						if(jsonResult["status"] == "success")
							setTimeout(function(){location.reload();},500);
					  },
            error   : function( xhr, err ) {
                        $('#signupForm .status').html(xhr);
                            alert(err);
                      }
        });    
        return false;
    });
  </script>