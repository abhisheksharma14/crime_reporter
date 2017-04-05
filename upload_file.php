<?php
session_start();
if ($_SESSION['role'] != "teacher") { header("location:404.php"); }
require_once("db.php");
if ( isset( $_FILES['pdfFile'] ) ) {
	$invalid_mime = array("exe", "bat", "sh", "py");
	$source_file = $_FILES['pdfFile']['name'];
	$ext = end(explode(".",$source_file));
	if (!in_array($ext, $invalid_mime)) {
		if (isset($_POST['rename'])) {
			$filename = $_POST['rename'].".$ext";
		}else{
			$filename = $_FILES['pdfFile']['name'];
		}
		$source_file = $_FILES['pdfFile']['tmp_name'];
		$dest_file = "./uploads/".$filename;
		if (file_exists($dest_file)) {
			$response = "The file name already exists!!";
		} else {
			if(move_uploaded_file( $source_file, $dest_file )) {
				$response = 1;

				$subject = filter_var($_POST["subject"], FILTER_SANITIZE_STRING);
				$chapter = filter_var($_POST["chapter"], FILTER_SANITIZE_STRING);
				$description = filter_var($_POST["description"], FILTER_SANITIZE_STRING);
				$file_path = filter_var('uploads/'.$filename, FILTER_SANITIZE_STRING);
				$uploaded_by = NULL;
				$download_url = "";

				$query_insert_note = "INSERT INTO $table_notes (subject, chapter, description, file_path, download_url, uploaded_by, uploaded_on, modified_on)
							VALUES ('$subject', '$chapter', '$description', '$file_path', '$download_url', '$uploaded_by', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')";
				if ($conn->query($query_insert_note)) {
					$note_id = $conn->insert_id;
					if(!generate_download_link($note_id)){
						$response = "Unable to generate download link. Please retry.";
						unlink($dest_file);
					}
				}else{
					unlink($dest_file);
					$response = "Could not insert notes infromations due to $conn->error. File not uploaded";
				}
			}else{
				$response = "Some error occured while uploading files. Please refresh and retry. If still persistes contact tech support";
			}
		}
	}else {
		$response = "Invalid File Choosen Please upload a file of other types. $ext files are not permitted";
	}
}else{
		$response = "File not Found. Please refresh and retry";
}

function generate_download_link($note_id){
	global $conn;
	global $table_notes;
	$download_url = md5("note".$note_id."note");
	$query_update_notes = "UPDATE $table_notes SET download_url = '$download_url' WHERE id = $note_id";
	if ($conn->query($query_update_notes)) {
		return true;
	}else{
		$query_delete_notes = "DELETE FROM $table_notes WHERE id = $note_id";
		$conn->query($query_delete_notes);
		return false;
	}
}

$_SESSION['response'] = $response;
$conn->close();
header("location:upload.php");
?>