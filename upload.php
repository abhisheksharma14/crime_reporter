<?php session_start();
if ($_SESSION['role'] != "teacher") { header("location:404.php"); }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Dashboard Template for Bootstrap</title>

    <link href="./css/bootstrap/font-awesome.min.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/dashboard.css" rel="stylesheet">
  </head>

  <body>
    <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
      <button class="navbar-toggler navbar-toggler-right hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="#">Dashboard</a>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="./index.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./404.php">Settings</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./404.php">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./index.php">Logout</a>
          </li>
        </ul>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">
          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link" href="./index.php">Current Files</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="./upload.php">Upload Notes <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./404.php">Manage Subjects</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./404.php">Settings</a>
            </li>
          </ul>
        </nav>

        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
          <h3>Upload A file</h3>
          <form class="form col-md-6 col-sm-6 col-lg-6 col-xs-12" enctype="multipart/form-data" action="./upload_file.php" method="post">
            <div class="form-group">
					    <label for="notes">Upload Notes: </label>
              <input type="hidden" name="MAX_FILE_SIZE" value="200000" /> 
					    <input type="file" class="btn" name="pdfFile" />
					  </div>
					  <div class="form-group">
					    <label for="subject">Subject Name </label>
              <input type="text" class="form-control" name="subject" />
					  </div>
					  <div class="form-group">
					    <label for="chapter">Chapter Name </label>
              <input type="text" class="form-control" name="chapter" />
					  </div>
					  <div class="form-group">
					    <label for="description">Decription </label>
              <input type="text" class="form-control" name="description" />
					  </div>
					  <div class="form-group">
					    <label for="rename">Rename File to </label>
              <input type="text" class="form-control" name="rename" />
					  </div>
            <div class="form-group">
              <input type="submit" class="btn btn-outline-info" value="Upload!" />
            </div>
          </form>
          <?php if (isset($_SESSION['response'])): 
          				if ($_SESSION['response'] == 1) {
          					echo '<span class="alert alert-success">File Uploaded Successfully.</span>';
          				}else{
          					echo '<span class="alert alert-danger">'.$_SESSION['response'].'</span>';
          				}
          				session_destroy();
           endif ?>
        </main>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="./js/vendor/jquery.min.js"><\/script>')</script>
    <script src="./js/tether.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
  </body>
</html>
