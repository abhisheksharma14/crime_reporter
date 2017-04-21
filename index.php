<?php session_start(); 
  require_once("./includes/db.php");
  if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    redirect("./user/list.php");
  }
  $conn->close();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Signin</title>
    
    <link href="./css/bootstrap/font-awesome.min.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/signin.css" rel="stylesheet">
  </head>

  <body>
    <div class="container">
      <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-login">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-6">
                <a href="#" class="active" id="login-form-link">Login</a>
              </div>
              <div class="col-xs-6">
                <a href="#" id="register-form-link">Register</a>
              </div>
            </div>
            <hr>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-lg-12">
                <form id="login-form" action="./user/validate.php" method="post" role="form" style="display: block;">
                  <div class="form-group">
                    <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
                  </div>
                  <div class="form-group">
                    <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
                  </div>
                  <?php if (isset($_SESSION['error'])): ?>
                  <div class="form-group">
                    <br>
                    <center><span class="alert alert-danger"><?php echo $_SESSION['error']; ?></span></center>
                    <br>
                  </div>
                  <?php unset($_SESSION['error']); endif ?>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-4 col-sm-offset-1">
                        <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Log In">
                      </div>
                      <div class="col-sm-4 col-sm-offset-1">
                        <a href="./user/validate.php?user=guest">
                          <input type="button" name="guest-login" id="guest-login" tabindex="5" class="form-control btn btn-login" value="Guest">
                        </a>
                      </div>
                    </div>
                  </div>
                </form>
                <form id="register-form" action="./user/validate.php" method="post" role="form" style="display: none;">
                  <div class="form-group">
                    <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
                  </div>
                  <div class="form-group">
                    <input type="text" name="name" id="name" tabindex="1" class="form-control" placeholder="Name" value="">
                  </div>
                  <div class="form-group">
                    <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="">
                  </div>
                  <div class="form-group">
                    <input type="number" name="mobile" id="mobile" tabindex="2" class="form-control" placeholder="Mobile Number" value="">
                  </div>
                  <div class="form-group">
                    <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password">
                  </div>
                  <?php if (isset($_SESSION['error'])): ?>
                  <div class="form-group">
                    <br>
                    <center><span class="alert alert-danger"><?php echo $_SESSION['error']; ?></span></center>
                    <br>
                  </div>
                  <?php unset($_SESSION['error']); endif ?>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-6 col-sm-offset-3">
                        <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register Now">
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./js/jquery.min.js"></script>
    <script src="./js/tether.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script>
    $(function() {
        $('#login-form-link').click(function(e) {
        $("#login-form").delay(100).fadeIn(100);
        $("#register-form").fadeOut(100);
        $('#register-form-link').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
      });
      $('#register-form-link').click(function(e) {
        $("#register-form").delay(100).fadeIn(100);
        $("#login-form").fadeOut(100);
        $('#login-form-link').removeClass('active');
        $(this).addClass('active');
        e.preventDefault();
      });
    });
    </script>

  </body>
</html>