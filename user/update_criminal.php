<?php
session_start();
require_once(URL."includes/db.php");
validate_login('report');
if (!isset($_POST['criminal_id'])) {
	$_SESSION['error'] = "Invalid Criminal ID recieved. Please Refresh and retry";
	$conn->close();
	redirect("user/criminal_list.php");
}else{
	$criminal_id = $_POST['criminal_id'];
}
$stored_images = [];
$response = 1;
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
			$dest_file = URL."uploads/".$filename;
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
$email = isset($_POST["email"])?$_POST["email"]:"";
$description = isset($_POST["description"])?$_POST["description"]:"";;
$address = isset($_POST["address"])?$_POST["address"]:"";;
$tags = isset($_POST["tags"])?$_POST["tags"]:"";
$status = isset($_POST["status"])?$_POST["status"]:"unsolved";

if (!strlen($name) || !strlen($description)) {
	$message .= "<br/><span class='alert alert-danger'>Name and description are compulsory</span>";
	$response = 0;
}
if ($response) {
	$name = filter_var($name, FILTER_SANITIZE_STRING);
	$email = filter_var($email, FILTER_SANITIZE_STRING);
	$description = filter_var($description, FILTER_SANITIZE_STRING);
	$address = filter_var($address, FILTER_SANITIZE_STRING);
	$tags = filter_var($tags, FILTER_SANITIZE_STRING);
	$images = filter_var(implode(",", $stored_images), FILTER_SANITIZE_STRING);
	$status = filter_var($status, FILTER_SANITIZE_STRING);
	$created_by = $_SESSION['user_id'];
	$created_date = date("Y-m-d H:i:s");
	$modified_date = date("Y-m-d H:i:s");

	$query_update_criminal = "UPDATE criminal 
							SET name = '$name', 
							email = '$email', 
							description = '$description', 
							tags = '$tags',
							status = '$status', 
							modified_date = '$modified_date'";
	if (strlen($images)) {
		$query_update_criminal .= ", image = '$images'";
	}
	$query_update_criminal .= " WHERE id =  '$criminal_id'";

	$result = $conn->query($query_update_criminal);
    if ($conn->error) {
      $message .= "<br/><span class='alert alert-danger'>".$conn->error."</span>";
    }
    if ($conn->affected_rows) {
      $message .= "<br/><span class='alert alert-success'>Crime reported successfully</span>";
    }else{
      $message .= "<br/><span class='alert alert-danger'>Error while inserting data</span>";
    }
}

$_SESSION['error'] = $message;
$conn->close();
redirect("./user/criminal_list.php");
?>