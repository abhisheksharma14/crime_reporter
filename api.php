<?php 
session_start();
require_once("./includes/db.php");
if (!(isset($_SESSION['user_id']))) {
	echo json_encode(array("response"=>0, "message"=>"Not autherized."));
	break;
}

switch ($_GET['action']) {
	case 'get_crimes':
		echo json_encode(get_all_crimes());		
		break;

	case 'get_crime':
		$crime_id = $_POST['id'];
		if (!$crime_id) {
			echo json_encode(array("response"=>0, "message"=>"Invalid Crime ID passed. Please refresh and retry."));
			break;
		}
		echo json_encode(get_crime($crime_id));		
		break;
	
	case 'delete_crime':
		if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
			echo json_encode(array("response"=>0, "message"=>"Not autherized."));
			break;
		}
		$crime_id = $_POST['id'];
		if (!$crime_id) {
			echo json_encode(array("response"=>0, "message"=>"Invalid Crime ID passed. Please refresh and retry."));
			break;
		}
		echo json_encode(delete_crime($crime_id));		
		break;

	case 'update_crime':
		if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
			echo json_encode(array("response"=>0, "message"=>"Not autherized."));
			break;
		}
		$crime_id = $_POST['id'];
		if (!$crime_id) {
			echo json_encode(array("response"=>0, "message"=>"Invalid Crime ID passed. Please refresh and retry."));
			break;
		}
		echo json_encode(update_crime($crime_id, $_POST));		
		break;

	case 'get_criminal':
		$criminal_id = $_POST['id'];
		if (!$criminal_id) {
			echo json_encode(array("response"=>0, "message"=>"Invalid Criminal ID passed. Please refresh and retry."));
			break;
		}
		echo json_encode(get_criminal($criminal_id));		
		break;
	
	case 'delete_criminal':
		if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
			echo json_encode(array("response"=>0, "message"=>"Not autherized."));
			break;
		}
		$criminal_id = $_POST['id'];
		if (!$criminal_id) {
			echo json_encode(array("response"=>0, "message"=>"Invalid Criminal ID passed. Please refresh and retry."));
			break;
		}
		echo json_encode(delete_criminal($criminal_id));		
		break;

	case 'update_criminal':
		if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
			echo json_encode(array("response"=>0, "message"=>"Not autherized."));
			break;
		}
		$criminal_id = $_POST['id'];
		if (!$criminal_id) {
			echo json_encode(array("response"=>0, "message"=>"Invalid Criminal ID passed. Please refresh and retry."));
			break;
		}
		echo json_encode(update_criminal($criminal_id, $_POST));		
		break;

	case 'get_mapping':
		$criminal_id = $_POST['id'];
		if (!$criminal_id) {
			echo json_encode(array("response"=>0, "message"=>"Invalid IDs passed. Please refresh and retry."));
			break;
		}
		echo json_encode(get_maping($criminal_id));
		break;
	
	case 'delete_mapping':
		if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
			echo json_encode(array("response"=>0, "message"=>"Not autherized."));
			break;
		}
		$criminal_id = $_POST['id'];
		if (!$criminal_id) {
			echo json_encode(array("response"=>0, "message"=>"Invalid IDs passed. Please refresh and retry."));
			break;
		}
		echo json_encode(delete_criminal($criminal_id));		
		break;

	case 'search':
		if (!isset($_POST['query'])) {
			echo json_encode(array("response"=>0, "message"=>"Not keywords recieved."));
			break;
		}
		$keywords = $_POST['query'];
		if (!$keywords) {
			echo json_encode(array("response"=>0, "message"=>"Invalid IDs passed. Please refresh and retry."));
			break;
		}
		echo json_encode(search($keywords));		
		break;

	default:
		echo json_encode(array("reposne"=>0, "message"=>"Unknown Method. Please check and retry"));
		break;
}

function get_all_crimes(){
	global $conn;
	$query_get_crime_details = "SELECT crime.*, GROUP_CONCAT(criminal.id) AS criminal_ids, user.name AS reported_by_user,
		GROUP_CONCAT(criminal.name) AS criminal_names, GROUP_CONCAT(criminal.image SEPARATOR ' | ') AS criminal_images
		FROM crime 
		LEFT JOIN criminal_mapping cm ON cm.crime_id = crime.id
		LEFT JOIN criminal ON criminal.id = cm.criminal_id
		INNER JOIN user ON user.id = crime.reported_by
		GROUP BY crime.id";
	$result = $conn->query($query_get_crime_details);

	if ($result->num_rows) {
		$key = 0;
	    while ($row = mysqli_fetch_assoc($result)) {
			$data["crime"][$key]['id'] = $row['id'];
			$data["crime"][$key]['name'] = $row['name'];
			$data["crime"][$key]['type'] = $row['type'];
			$data["crime"][$key]['description'] = $row['description'];
			$data["crime"][$key]['reported_by'] = $row['reported_by_user'];
			$data["crime"][$key]['created_date'] = date("Y-m-d",strtotime($row['created_date']));
			$data["crime"][$key]['images'] = $row['images'];
			$data["crime"][$key]['status'] = $row['status'];
			$data["crime"][$key]['tags'] = $row['tags'];
			$data["crime"][$key]['criminal_ids'] = $row['criminal_ids'];
			$data["crime"][$key]['criminal_names'] = $row['criminal_names'];
			$data["crime"][$key]['criminal_images'] = $row['criminal_images'];
	    	$key++;
	    };
		$data["response"] = 1;
		$data["message"] = "Crimes Found";
  	}else{
		$data["response"] = 1;
		$data["message"] = "No result found. Please refresh and retry.";
  	}
  	return $data;
}

function get_crime($crime_id){
	global $conn;
	$query_get_crime_details = "SELECT crime.*, GROUP_CONCAT(criminal.id) AS criminal_ids, user.name AS reported_by_user,
		GROUP_CONCAT(criminal.name) AS criminal_names, GROUP_CONCAT(criminal.image SEPARATOR ' | ') AS criminal_images
		FROM crime 
		LEFT JOIN criminal_mapping cm ON cm.crime_id = crime.id
		LEFT JOIN criminal ON criminal.id = cm.criminal_id
		INNER JOIN user ON user.id = crime.reported_by
		WHERE crime.id = $crime_id
		GROUP BY crime.id";
	$result = $conn->query($query_get_crime_details);

	if ($result->num_rows) {
	    $row = mysqli_fetch_assoc($result);
		$data["crime"]['id'] = $row['id'];
		$data["crime"]['name'] = $row['name'];
		$data["crime"]['type'] = $row['type'];
		$data["crime"]['description'] = $row['description'];
		$data["crime"]['reported_by'] = $row['reported_by_user'];
		$data["crime"]['created_date'] = date("Y-m-d",strtotime($row['created_date']));
		$data["crime"]['images'] = $row['images'];
		$data["crime"]['status'] = $row['status'];
		$data["crime"]['tags'] = $row['tags'];
		$data["crime"]['criminal_ids'] = $row['criminal_ids'];
		$data["crime"]['criminal_names'] = $row['criminal_names'];
		$data["crime"]['criminal_images'] = $row['criminal_images'];
		$data["response"] = 1;
		$data["message"] = "Crime Details Found";
  	}else{
		$data["response"] = 1;
		$data["message"] = "No result found. Please refresh and retry.";
  	}
  	return $data;
}

function delete_crime($crime_id){
	global $conn;
	$query_delete_mapping = "DELETE FROM criminal_mapping WHERE crime_id = $crime_id";	
	$query_delete_crime = "DELETE FROM crime WHERE id  = $crime_id";
	$conn->autocommit(FALSE);
	$result = $conn->query($query_delete_mapping);
	if ($conn->error) {
		$conn->rollback();
	}else{
		$conn->query($query_delete_crime);
		if ($conn->error) {
			$conn->rollback();
		}else{
			$conn->commit();
		}
	}
	if ($conn->error) {
		$data['response'] = 0;
		$data['message'] = "Error while deleting crime.";
	}else{
		$data['response'] = 1;
		$data['message'] = "Deleted Successfully crime.";
	}
	return $data;
}

function update_crime($crime_id, $data){
	global $conn;
}

function get_criminal($criminal_id){
	global $conn;
	$query_get_criminal_details = "SELECT criminal.*, GROUP_CONCAT(crime.id) AS crime_ids,
		GROUP_CONCAT(crime.name) AS crime_names,  user.name AS reported_by_user
		FROM criminal 
		LEFT JOIN criminal_mapping cm ON cm.criminal_id = criminal.id
		LEFT JOIN crime ON crime.id = cm.crime_id
		INNER JOIN user ON user.id = criminal.created_by
		WHERE criminal.id = $criminal_id
		GROUP BY criminal.id";
	$result = $conn->query($query_get_criminal_details);
	if ($result->num_rows) {
	    $row = mysqli_fetch_assoc($result);
		$data["criminal"]['id'] = $row['id'];
		$data["criminal"]['name'] = $row['name'];
		$data["criminal"]['address'] = $row['address'];
		$data["criminal"]['description'] = $row['description'];
		$data["criminal"]['created_by'] = $row['reported_by_user'];
		$data["criminal"]['created_date'] = $row['created_date'];
		$data["criminal"]['images'] = $row['image'];
		$data["criminal"]['status'] = $row['status'];
		$data["criminal"]['tags'] = $row['tags'];
		$data["response"] = 1;
		$data["message"] = "Crime Details Found";
  	}else{
		$data["response"] = 0;
		$data["message"] = "No result found. Please refresh and retry.";
  	}
  	return $data;
}

function delete_criminal($criminal_id){
	global $conn;
	$query_delete_mapping = "DELETE FROM criminal_mapping WHERE criminal_id = $criminal_id";	
	$query_delete_criminal = "DELETE FROM criminal WHERE id  = $criminal_id";
	$conn->autocommit(FALSE);
	$result = $conn->query($query_delete_mapping);
	if ($conn->error) {
		$conn->rollback();
	}else{
		$conn->query($query_delete_criminal);
		if ($conn->error) {
			$conn->rollback();
		}else{
			$conn->commit();
		}
	}
	if ($conn->error) {
		$data['response'] = 0;
		$data['message'] = "Error while deleting criminal.";
	}else{
		$data['response'] = 1;
		$data['message'] = "Deleted Successfully criminal.";
	}
	return $data;
}

function update_criminal($criminal_id){
	global $conn;
}

function get_mapping($where){
	global $conn;
}

function delete_mapping($where){
	global $conn;
}

function search($keywords){
	global $conn;
	$keywords = explode(" ", $keywords);
	$where_clause = "";
	foreach ($keywords as $key => $value) {
		if ($key == 0) {
			$where_clause .= " description LIKE '%$value%' ";
		}else{
			$where_clause .= " OR description LIKE '%$value%' ";
		}
	}

	$query_search_crime = "SELECT crime.*, user.name AS reported_by_user FROM crime INNER JOIN user ON crime.reported_by = user.id WHERE $where_clause";
	$result_crimes = $conn->query($query_search_crime);
	$data['result'] = array();

	$idx = 0;
	if ($result_crimes->num_rows) {
	    while($row = mysqli_fetch_assoc($result_crimes)){
			$data['result'][$idx]['id'] = $row['id'];
			$data['result'][$idx]['name'] = $row['name'];
			$data['result'][$idx]['description'] = $row['description'];
			$data['result'][$idx]['created_by'] = $row['reported_by_user'];
			$data['result'][$idx]['created_date'] = $row['created_date'];
			$data['result'][$idx]['status'] = $row['status'];
			$data['result'][$idx]['type'] = "crime";
			$idx++;
	    }
  	}

	$query_search_criminal = "SELECT criminal.*, user.name AS reported_by_user FROM criminal INNER JOIN user ON criminal.created_by = user.id WHERE $where_clause";
	$result_criminals = $conn->query($query_search_criminal);
	if ($result_criminals->num_rows) {
	    while($row = mysqli_fetch_assoc($result_criminals)){
			$data['result'][$idx]['id'] = $row['id'];
			$data['result'][$idx]['name'] = $row['name'];
			$data['result'][$idx]['description'] = $row['description'];
			$data['result'][$idx]['created_by'] = $row['reported_by_user'];
			$data['result'][$idx]['created_date'] = $row['created_date'];
			$data['result'][$idx]['status'] = $row['status'];
			$data['result'][$idx]['type'] = "criminal";
			$idx++;
	    }
  	}

  	if (count($data['result'])) {
  		$data['response'] = 1;
  	}else{
  		$data['response'] = 0;
  		$data['message'] = "No data found. Try other keywords.";
  	}
  	return $data;
}

$conn->close();
?>