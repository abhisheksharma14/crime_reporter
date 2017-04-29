<?php 
session_start();
session_destroy();
header("location:".URL."/index.php");
?>