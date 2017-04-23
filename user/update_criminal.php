<?php
session_start();
require_once("../includes/db.php");
validate_login('report');
if (!isset($_POST['crime_id'])) {
	$_SESSION['error'] = "Invalid Crime ID recieved. Please Refresh and retry";
	$conn->close();
	redirect("user/list.php");
}else{
	$crime_id = $_POST['crime_id'];
}
$response = 1;
$stored_images = [];
if ( isset( $_FILES['images'] ) && $_FILES['images']['error'] == 0) {
	$valid_mime = array("jpg", "png", "jpeg");
	$source_files = $_FILES['images']['name'];
	$message = "";
	$response = 0;
	foreach ($source_files as $key => $source_file) {
		$ext = end(explode(".",$source_file));
		$filename = time().$_FILES['images']['name'][$key];
		if (in_array(trim(strtolower($ext)), $valid_mime)) {	
			$source_file = $_FILES['images']['tmp_name'][$key];
			$dest_file = "../uploads/".$filename;
			if (file_exists($dest_file)) {
				$message = "<br/><span class='alert alert-danger'> $filenameThe file name already exists!! </span>" ;
			} else {
				if(move_uploaded_file( $source_file, $dest_file )) {
					array_push($stored_images, filter_var($filename, FILTER_SANITIZE_STRING));
					$message .= "<br/><span class='alert alert-success'> $filename Image Uploaded </span>";
					$response = 1;
				}else{
					$message .= "<br/><span class='alert alert-danger'> $filename Image could NOT be Uploaded </span>";
				}
			}
		}else {
			$message .= "<br/><span class='alert alert-success'> $filename: Invalid File Choosen Please upload a file of other types. $ext files are not permitted </span>";
		}
	}
}else{
		$message = "<br/><span class='alert alert-warning'>No file to upload </span>";
}

$name = isset($_POST["name"])?$_POST["name"]:"";
$type = isset($_POST["type"])?$_POST["type"]:"";
$description = isset($_POST["description"])?$_POST["description"]:"";;
$tags = isset($_POST["tags"])?$_POST["tags"]:"";
$crime_date = isset($_POST["occured_on"])?$_POST["occured_on"]:"";
$status = isset($_POST["status"])?$_POST["status"]:"unsolved";
$criminals = isset($_POST["criminals"])?$_POST["criminals"]:0;

if (!strlen($name) || 
	!strlen($type) || 
	!strlen($description) ||
	// !strlen($tags) || 
	!strlen($crime_date)) {
	$message .= "<br/><span class='alert alert-danger'>All fields are mandetory</span>";
	$response = 0;
}
if ($response) {
	$name = filter_var($name, FILTER_SANITIZE_STRING);
	$type = filter_var($type, FILTER_SANITIZE_STRING);
	$description = filter_var($description, FILTER_SANITIZE_STRING);
	$tags = filter_var($tags, FILTER_SANITIZE_STRING);
	$reported_by = $_SESSION['user_id'];
	$crime_date = filter_var($crime_date, FILTER_SANITIZE_STRING);
	$status = filter_var($status, FILTER_SANITIZE_STRING);
	$images = filter_var(implode(",", $stored_images), FILTER_SANITIZE_STRING);
	$modified_date = date("Y-m-d H:i:s");

	$query_update_crime = "UPDATE crime 
							SET name = '$name', 
							type = '$type', 
							description = '$description', 
							tags = '$tags',
							reported_by = '$reported_by',
							crime_date = '$crime_date',
							status = '$status', 
							modified_date = '$modified_date'";
	if (strlen($images)) {
		$query_update_crime .= ", images = '$images'";
	}
	$query_update_crime .= " WHERE id =  '$crime_id'";

	$result = $conn->query($query_update_crime);
    if ($conn->error) {
    	$message .= "<br/><span class='alert alert-danger'>".$conn->error."</span>";
    }
    if ($conn->affected_rows) {
		if ($criminals) {
			$query_delete_mapping = "DELETE FROM criminal_mapping WHERE crime_id = $crime_id";
			$conn->query($query_delete_mapping);
			foreach ($criminals as $key => $criminal) {
				$query_insert_mapping = "INSERT INTO criminal_mapping VALUES(NULL, $crime_id, $criminal, NOW(), NOW())";
				$mapp = $conn->query($query_insert_mapping);
			}
		}
    	$message .= "<br/><span class='alert alert-success'>Crime reported successfully</span>";
    }else{
      $message .= "<br/><span class='alert alert-danger'>Error while updating data</span>";
    }
}

$_SESSION['error'] = $message;
$conn->close();
redirect("user/list.php");
?>