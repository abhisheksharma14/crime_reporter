<?php 
session_start();
require_once("db.php");
validate_login();
$url = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Crime Reports</title>

    <link href="../css/bootstrap/font-awesome.min.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../css/bootstrap/bootstrap-multiselect.css" rel="stylesheet">
    <?php
      if (strpos($url, "list.php")) {
        echo '<link href="../css/dataTables.bootstrap.min.css" rel="stylesheet">';
      }
    ?>
    <!-- Custom styles for this template -->
    <link href="../css/dashboard.css" rel="stylesheet">
  </head>

  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span> 
	      </button>
	      <a class="navbar-brand" href="#">Dashboard</a>
	    </div>
	    <div class="collapse navbar-collapse" id="myNavbar">
	      <ul class="nav navbar-nav">
	        <li class="active"><a href="#">Home</a></li>
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="../user/logout.php">Logout <span class="text-danger glyphicon glyphicon-log-out"></span></a></li>
	      </ul>
	    </div>
	  </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-xs-3 col-sm-3 col-md-2 col-lg-2 hidden-xs-down bg-faded sidebar">
          <ul class="nav nav-pills flex-column">
            <!-- <li class="nav-item">
              <a class="nav-link active" href="./dashboard.php"> <i class="fa fa-dashboard fa-lg"></i> Dashboard <span class="sr-only">(current)</span></a>
            </li> -->
            <li class="nav-item">
              <a class="nav-link active" href="./list.php"> <i class="fa fa-list fa-lg"></i>  Crime List <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./criminal_list.php"> <i class="fa fa-user fa-lg"></i> Criminal List</a>
            </li>
          </ul>
        </nav>

        <main class="col-xs-9 col-sm-9 col-sm-offset-3 col-md-10 col-lg-10 col-xs-offset-3 col-sm-offset-3 col-md-offset-2 col-lg-offset-2">
        <!-- Content -->