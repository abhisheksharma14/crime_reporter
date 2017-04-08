<?php 
session_start();
require_once("../db.php"); 
echo $_SESSION['user_id'];
echo $_SESSION['role'];
$conn->close();
?>