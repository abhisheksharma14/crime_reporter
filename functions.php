<?php 
session_start();
require_once("../db.php");
if (!(isset($_SESSION['user_id']))) {
	redirect("index.php");
}

switch ($_GET['action']) {
	case 'get_crime':
		$crime_id = $_GET['id'];
		if (!$crime_id) {
			redirect("index.php");
		}
		echo json_encode(get_crime($crime_id));		
		break;
	
	case 'delete_crime':
		if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
			redirect("index.php");
		}
		$crime_id = $_GET['id'];
		if (!$crime_id) {
			redirect("index.php");
		}
		echo json_encode(delete_crime($crime_id));		
		break;

	case 'update_crime':
		if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
			redirect("index.php");
		}
		$crime_id = $_GET['id'];
		if (!$crime_id) {
			redirect("index.php");
		}
		echo json_encode(update_crime($crime_id, $_POST));		
		break;

	case 'get_criminal':
		$criminal_id = $_GET['id'];
		if (!$criminal_id) {
			redirect("index.php");
		}
		echo json_encode(get_criminal($criminal_id));		
		break;
	
	case 'delete_criminal':
		if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
			redirect("index.php");
		}
		$criminal_id = $_GET['id'];
		if (!$criminal_id) {
			redirect("index.php");
		}
		echo json_encode(delete_criminal($criminal_id));		
		break;

	case 'update_criminal':
		if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
			redirect("index.php");
		}
		$criminal_id = $_GET['id'];
		if (!$criminal_id) {
			redirect("index.php");
		}
		echo json_encode(update_criminal($criminal_id, $_POST));		
		break;

	default:
		echo json_encode(array("reposne"=>0, "message"=>"Unkown Method. Please check and retry"));
		break;
}

function get_crime($crime_id){

}

function delete_crime($crime_id){

}

function update_crime($crime_id, $data){

}

function get_criminal($criminal_id){

}

function delete_criminal($criminal_id){

}

function update_criminal($criminal_id){

}

function get_mapping($where){

}

function delete_mapping($where){

}

$conn->close();
?>