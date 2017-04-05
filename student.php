<?php 
session_start();
require_once("db.php"); 
$_SESSION["role"] = "student";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Dashboard</title>

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
            <a class="nav-link" href="./student.php">Home <span class="sr-only">(current)</span></a>
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
              <a class="nav-link active" href="./student.php">Current Files <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./404.php">Settings</a>
            </li>
          </ul>
        </nav>

        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
          <h3>Uploaded Files</h3>
          <table class="table table-hover table-condensed table-border">
          	<thead>
          		<tr>
          			<th>#</th>
          			<th>Subject</th>
          			<th>Chapter</th>
          			<th>Description</th>
          			<th>Created On</th>
          			<th>Actions</th>
          		</tr>
          	</thead>
          	<tbody>
      		<?php
      		$notes = get_all_uploaded_files();
      		if (count($notes)) {
      			foreach ($notes as $key => $note) {
      				echo "<tr>
      						<td>".($key+1)."
      						<td>".$note["subject"]."
      						<td>".$note["chapter"]."
      						<td>".$note["description"]."
      						<td>".$note["uploaded_on"]."
      						<td>
      							<a href='./file.php?action=download&file=".$note["download_url"]."'><span class='fa fa-download fa-lg pull-left'></span></a>
  						</tr>";
      			}
      		}

      		?>
          	</tbody>
          </table>
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
<?php
function get_all_uploaded_files(){
	global $conn;
	global $table_notes;
	$query_get_uploaded_files = "SELECT * FROM notes";
	$result = $conn->query($query_get_uploaded_files);
	$notes = array();
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	        array_push($notes, $row);
	    }
	}
	return $notes;
}
$conn->close();
?>