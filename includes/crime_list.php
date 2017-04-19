<?php
if (isset($_POST['from_date'])) {
    $from_date = $_POST['from_date'];
}else{
  $from_date = date("Y-m-d", strtotime("-7 days"));
}

if (isset($_POST['to_date'])) {
    $to_date = $_POST['to_date'];
}else{
  $to_date = date("Y-m-d");
}

function fetch_crime_list($from, $to){
  global $conn;
  $query_fetch_crimes = "SELECT crime.*, user.name AS reported_by_user 
                          FROM crime
                          INNER JOIN user ON crime.reported_by = user.id 
                          WHERE crime.created_date >= '$from 00:00:00' AND crime.created_date <= '$to 23:59:59'
                          ORDER BY crime.created_date DESC";
  $result = $conn->query($query_fetch_crimes);
  if ($result->num_rows) {
    $key = 0;
    while ($row = mysqli_fetch_assoc($result)) {
      $data[$key]['id'] = $row['id'];
      $data[$key]['name'] = $row['name'];
      $data[$key]['type'] = $row['type'];
      $data[$key]['description'] = $row['description'];
      $data[$key]['reported_by'] = $row['reported_by_user'];
      $data[$key]['created_date'] = $row['created_date'];
      $data[$key]['images'] = $row['images'];
      $data[$key]['status'] = $row['status'];
      $key++;
    }
  }else{
    $data = array();
  }
  return $data;
}

$crime_list = fetch_crime_list($from_date, $to_date);
?>

<h3 class="pull-left">Crime List</h3>
<button class="btn btn-success pull-right" data-toggle="modal" data-target="#report-crime"><i class="fa fa-plus-circle"></i> Report New Crime</button>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" id="crime-list" method="post" accept-charset="utf-8" class="form form-inline col-md-7 col-sm-7 col-lg-7 col-xs-12 pull-right">
  <div class="form-group">
    <label for="name">From </label>
    <input type="date" class="form-control" name="from_date" value="<?php echo $from_date;?>" />
    <label for="name"> To </label>
    <input type="date" class="form-control" name="to_date" value="<?php echo $to_date;?>" />
    <input type="submit" class="form-control btn btn-info" name="submit" />
  </div>
</form>
<div style="clear: both;"></div>
<hr>
<table id="crime-list-table" class="table table-hover table-condensed table-border mdl-data-table" cellspacing="0">
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Type</th>
      <th>Status</th>
      <th>Reported By</th>
      <th>Dated</th>
      <?php if ($_SESSION['role'] == 'admin'): ?>
        <th>Action</th>
      <?php endif ?>
    </tr>
  </thead>
  <tbody>
  <?php
  if (count($crime_list)) {
    foreach ($crime_list as $key => $crime) {
      echo '<tr>
              <td>'.($key+1).'</td>
              <td>'.$crime['name'].'</td>
              <td>'.$crime['type'].'</td>
              <td>'.$crime['status'].'</td>
              <td>'.$crime['reported_by'].'</td>
              <td>'.$crime['created_date'].'</td>';
      if ($_SESSION['role'] == 'admin')
        echo '<td>
                <i class="fa fa-eye pull-left btn btn-sm text-info" onclick="getCrime('.$crime['id'].')"></i> 
                <i class="fa fa-pencil pull-left btn btn-sm text-warning" onclick="editCrime('.$crime['id'].')"></i> 
                <i class="fa fa-trash text-danger pull-left btn btn-sm" onclick="deleteCrime('.$crime['id'].')"></i>
              </td>';
      else 
        echo '<td>
                <i class="fa fa-eye pull-left btn btn-sm text-info" onclick="getCrime('.$crime['id'].')"></i>
              </td>';
      echo  '</tr>';
    }
  }else{
    echo "<tr><td colspan=9>No data found. Please try another date.</td></tr>";
  }
  ?>
  </tbody>
</table>

<div class="modal fade" tabindex="-1" role="dialog" id="report-crime">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <form class="form col-md-12 col-sm-12 col-lg-12 col-xs-12" enctype="multipart/form-data" action="./upload_crime.php" method="post">
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
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-info pull-right" value="Upload!" />
          </div>
        </form>
        <style type="text/css" media="screen">
          .response span.alert{
            width: 100%;
            float: left;
          }
        </style>
        <div class="response col-md-12 col-sm-12 col-lg-12 col-xs-12 pull-right">
          <?php
          if (isset($_SESSION['error'])){
            echo $_SESSION['error'];
            $_SESSION['error'] = "";
          }
          ?>
        </div>
        <div style="clear: both;"></div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>