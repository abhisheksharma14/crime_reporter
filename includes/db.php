<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
function redirect($url){
	$serving_directory = "crime";
	$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/$serving_directory/$url";
	ob_start();
    header('Location: '.$actual_link);
    ob_end_flush();
    die();
}

function validate_login($url = NULL){
	if (!isset($_SESSION['user_id'])) {
		redirect("index.php");
	}
	switch ($url) {
		case 'report':
			if ($_SESSION['role'] !== 'admin'){
				redirect("./user/member.php");
			}
			break;
		
		case 'admin':
			if ($_SESSION['role'] !== 'admin'){
				redirect("./user/member.php");
			}
			break;

		case 'member':
			if ($_SESSION['role'] !== 'member'){
				redirect("index.php");
			}
			break;

		default:
			break;
	}
}

$servername = "localhost";
$username = "urbanwand";
$password = "urbanwand";
$database = "crime";

//tables
$table_notes = "notes";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>