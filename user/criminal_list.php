<?php include_once("../includes/header.php");?>
<?php include_once("../includes/criminal_list.php");?>
<?php include_once("../includes/footer.php");?>
<?php 
if (isset($_SESSION['error']) && strlen($_SESSION['error'])) {
    echo '<script>$("#add-criminal").modal("show")</script>';
}
?>