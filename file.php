<?php
session_start();
require_once("db.php");
if (!check_user_details()) {
	header("location:404.php");
}

$action= $_GET['action'];
$download_url = $_GET['file'];
if ($action == "delete" && $_SESSION['role'] == "teacher") {
	$file = get_file_by_download_url($download_url);
	if (!count($file)) {
		header("location:404.php");
	}
	$file = $file[0];
	if (count($file)) {
		unlink(realpath($file['file_path']));
		$query_delete_notes = "DELETE FROM $table_notes WHERE id = ".$file['id'];
		$conn->query($query_delete_notes);
		header("location:index.php");
	}else{
		header("location:404.php");
	}
}else if ($action == "download") {
	$file = get_file_by_download_url($download_url);
	if (!count($file)) {
		header("location:404.php");
	}
	$file = $file[0];
	header('Content-Description: File Transfer');
	header('Content-Type: application/force-download');
	header("Content-Disposition: attachment; filename=\"" . end(explode("/", $file['file_path'])) . "\";");
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($file['file_path']));
	ob_clean();
	flush();
	readfile($file['file_path']); //showing the path to the server where the file is to be download
	exit;
}else{
	header("location:404.php");
}


function check_user_details(){
	return isset($_SESSION['role']);
}

function get_file_by_download_url($download_url){
	global $conn;
	global $table_notes;

	$query_get_notes_by_url = "SELECT * FROM $table_notes WHERE download_url = '$download_url'";
	$result = $conn->query($query_get_notes_by_url);
	$file = array();
	if ($result->num_rows > 0 ) {
		while($row = $result->fetch_assoc()) {
	        array_push($file, $row);
	    }
	}
	return $file;
}
$conn->close();
?>