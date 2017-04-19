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

function fetch_criminal_list($from, $to){
  global $conn;
  $query_fetch_crimes = "SELECT criminal.*, user.name AS created_by_user 
                          FROM criminal
                          INNER JOIN user ON criminal.created_by = user.id 
                          WHERE criminal.created_date >= '$from 00:00:00' AND criminal.created_date <= '$to 23:59:59'
                          ORDER BY criminal.created_date DESC";
  $result = $conn->query($query_fetch_crimes);
  if ($result->num_rows) {
    $key = 0;
    while ($row = mysqli_fetch_assoc($result)) {
      $data[$key]['id'] = $row['id'];
      $data[$key]['name'] = $row['name'];
      $data[$key]['address'] = $row['address'];
      $data[$key]['description'] = $row['description'];
      $data[$key]['created_by'] = $row['created_by_user'];
      $data[$key]['created_date'] = $row['created_date'];
      $data[$key]['images'] = $row['image'];
      $data[$key]['status'] = $row['status'];
      $key++;
    }
  }else{
    $data = array();
  }
  return $data;
}

$criminal_list = fetch_criminal_list($from_date, $to_date);
?>

<h3 class="pull-left">Criminal List</h3>
<button class="btn btn-success pull-right" data-toggle="modal" data-target="#add-criminal"><i class="fa fa-plus-circle"></i> New Criminal</button>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" id="crime-list" method="post" accept-charset="utf-8" class="form form-inline col-md-8 col-sm-8 col-lg-8 col-xs-12 pull-right">
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
      <th>Address</th>
      <th>Status</th>
      <th>Reported By</th>
      <th>Dated</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
  <?php
  if (count($criminal_list)) {
    foreach ($criminal_list as $key => $criminal) {
      echo '<tr>
              <td>'.($key+1).'</td>
              <td>'.$criminal['name'].'</td>
              <td>'.$criminal['address'].'</td>
              <td>'.$criminal['status'].'</td>
              <td>'.$criminal['created_by'].'</td>
              <td>'.$criminal['created_date'].'</td>';
      if ($_SESSION['role'] == 'admin')
        echo '<td>
                <i class="fa fa-eye pull-left btn btn-sm text-info" onclick="getCriminal('.$criminal['id'].')"></i> 
                <i class="fa fa-pencil pull-left btn btn-sm text-warning" onclick="editCriminal('.$criminal['id'].')"></i> 
                <i class="fa fa-trash text-danger pull-left btn btn-sm" onclick="deleteCriminal('.$criminal['id'].')"></i>
              </td>';
      else 
        echo '<td>
                <i class="fa fa-eye pull-left btn btn-sm text-info" onclick="getCrime('.$criminal['id'].')"></i>
              </td>';
      echo  '</tr>';
    }
  }else{
    echo "<tr><td colspan=7>No data found. Please try another date.</td></tr>";
  }
  ?>
  </tbody>
</table>

<div class="modal fade" tabindex="-1" role="dialog" id="add-criminal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <form class="form col-md-12 col-sm-12 col-lg-12 col-xs-12" enctype="multipart/form-data" action="./upload_criminal.php" method="post">
          <div class="form-group">
            <label for="name">Name </label>
            <input type="text" class="form-control" name="name" />
          </div>
          <div class="form-group">
            <label for="email">Email </label>
            <input type="email" class="form-control" name="email" />
          </div>
          <div class="form-group">
            <label for="address">Address </label>
            <textarea class="form-control" name="address" rows="5"></textarea>
          </div>
          <div class="form-group">
            <label for="description">Decription </label>
            <textarea class="form-control" name="description" rows="5"></textarea>
          </div>
          <div class="form-group">
            <label for="status">Status </label>
            <select name="status" class="form-control">
              <option value="suspect">Suspect</option>
              <option value="caught">Caught</option>
              <option value="uncaught">Uncaught</option>
            </select>
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