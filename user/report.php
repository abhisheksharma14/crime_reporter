<?php include_once("../includes/header.php");?>
<h3 class="pull-left">Upload Crime Details</h3>
<div style="clear: both;"></div>
<form class="form col-md-6 col-sm-6 col-lg-6 col-xs-12" enctype="multipart/form-data" action="./upload_crime.php" method="post">
  <div class="form-group">
    <label for="name">Name </label>
    <input type="text" class="form-control" name="name" />
  </div>
  <div class="form-group">
    <label for="type">Type </label>
    <input type="text" class="form-control" name="type" />
  </div>
  <div class="form-group">
    <label for="description">Decription </label>
    <textarea class="form-control" name="description" rows="5"></textarea>
  </div>
  <div class="form-group">
    <label for="description">Occured On </label>
    <input type="date" name="occured_on" value="<?php echo date('Y-m-d');?>" max="<?php echo date('Y-m-d');?>" class="form-control">
  </div>
  <div class="form-group">
    <label for="notes">Upload Image: </label>
    <input type="hidden" name="MAX_FILE_SIZE" value="200000" /> 
    <input type="file" class="btn" name="images[]" multiple/>
  </div>
  <div class="form-group">
    <input type="submit" class="btn btn-info pull-right" value="Upload!" />
  </div>
</form>
<style type="text/css" media="screen">
  .response span.alert{
    width: 100%;
    float: left;
  }
</style>
<div class="response col-md-5 col-sm-5 col-lg-5 col-xs-12 pull-right">
  <?php
  if (isset($_SESSION['error'])){
    echo $_SESSION['error'];
    $_SESSION['error'] = "";
  }
  ?>
</div>
<?php include_once("../includes/footer.php");?>