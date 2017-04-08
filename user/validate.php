<?php 
session_start();
require_once("../db.php"); 

//login form
if (isset($_POST['login-submit'])) {
  if (!isset($_POST['username']) || !isset($_POST['password'])) {
    $_SESSION['error'] = "Please enter all fields and retry.";
    redirect("index.php");
  }else{
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $query_validate_user = "SELECT * FROM user WHERE username = '$username' AND password = '".md5($password)."'";
    $result = $conn->query($query_validate_user);
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['role'] = $row['role'];
      if ($row['role'] == 'admin') {
        redirect("./user/admin.php");
      }else if($row['role'] == 'member') {
        redirect("./user/member.php");
      }
    }else{
      $_SESSION['error'] = "Invalid Username Password used. Please check and retry.";
      redirect("index.php");
    }
  }
}

if (isset($_POST['register-submit'])) {
  $_SESSION['error'] = "";
  foreach ($_POST as $key => $value) {
    if (!strlen($value)) {
      $_SESSION['error'] = "All fields are compulsory.";
    }
  }
  if (strlen($_SESSION['error'])) {
    redirect("index.php");
  }
  if ($_POST['password'] != $_POST['confirm-password']) {
    $_SESSION['error'] = "Password do not match.";
  }
  if (strlen($_SESSION['error'])) {
    redirect("index.php");
  }

  $query_validate_user = "SELECT * FROM user WHERE username = '$_POST[username]' OR email = '$_POST[email]' OR mobile = '$_POST[mobile]'";
  $result = $conn->query($query_validate_user);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['error'] = "User already exists.";
    redirect("index.php");
  }else{
    $password = md5($_POST['password']);
    $query_insert_user = "INSERT INTO user VALUES(NULL, '$_POST[username]', 'member', '$_POST[name]', '$_POST[email]', '$_POST[mobile]', '$password', NULL, 1, 'date(\'Y-m-d H:i:s\')', 'date(\'Y-m-d H:i:s\')')";
    $result = $conn->query($query_insert_user);
    if ($conn->error) {
      echo $conn->error;
      die();
    }
    if ($conn->affected_rows) {
      $_SESSION['user_id'] = $conn->insert_id;
      $_SESSION['role'] = "member";
      redirect("./user/member.php");
    }else{
      $_SESSION['error'] = "Error While creating user. Please retry after sometime.";
      redirect("index.php");
    }
  }

}

$conn->close();
?>