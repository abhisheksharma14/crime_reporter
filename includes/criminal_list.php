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
                <i class="fa fa-eye pull-left btn btn-sm text-info" onclick="get_crime('.$crime['id'].')"></i> 
                <i class="fa fa-pencil pull-left btn btn-sm text-warning" onclick="edit_crime('.$crime['id'].')"></i> 
                <i class="fa fa-trash text-danger pull-left btn btn-sm" onclick="delete_crime('.$crime['id'].')"></i>
              </td>';
      else 
        echo '<td>
                <i class="fa fa-eye pull-left btn btn-sm text-info" onclick="get_crime('.$crime['id'].')"></i>
              </td>';
      echo  '</tr>';
    }
  }else{
    echo "<tr><td colspan=9>No data found. Please try another date.</td></tr>";
  }
  ?>
  </tbody>
</table>