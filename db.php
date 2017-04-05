<?php
// if(isset($open) && $open){}
// else {header("location:404.php");exit;}

$servername = "localhost";
$username = "urbanwand";
$password = "urbanwand";
$database = "notes";

//tables
$table_notes = "notes";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>