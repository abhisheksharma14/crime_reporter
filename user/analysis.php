<?php include_once("../includes/header.php");?>
<h3 class="pull-left">Search</h3>
<div style="clear: both;"></div>
<form class="form">
  <div class="input-group col-lg-8 col-md-8 col-sm-10 col-xs-12 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
    <input type="text" class="form-control" name="search_query" placeholder="Enter at least 3 characters to search..." onkeyup="search()"">
    <span class="input-group-btn">
      <button class="btn btn-default btn-info" type="button" id="search-btn" onclick="search()">Search &nbsp; &nbsp;<i class="fa fa-search"></i></button>
    </span>
  </div>
</form>
<hr>
<div>
  <table id="search-result-table" class="table table-hover display" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Type</th>
        <th>Status</th>
        <th>Reported By</th>
        <th>Dated</th>
        <th>Modified On</th>
      </tr>
    </thead>
  </table>
  <span class="alert alert-warning" style="display: none;" id="search-response"></span>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="crime-details">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span>Crime Details</span> <small>Date</small></h4>
      </div>
      <div class="modal-body">
        <div id="crime-image-carousel" class="carousel slide col-xs-4 col-sm-4 col-md-4 col-lg-4 pull-left" data-ride="carousel">
          <!-- Indicators -->
          <ol class="carousel-indicators"></ol>
          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox"></div>
          <!-- Left and right controls -->
          <a class="left carousel-control" href="#crime-image-carousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#crime-image-carousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 pull-right" id="crime-data">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 description"></div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 reported-by"></div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 type"></div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 criminals"></div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tags"></div>
        </div>
        <div style="clear: both;"></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default pull-right" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="criminal-details">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span>Criminal Details</span> <small>Date</small></h4>
      </div>
      <div class="modal-body">
        <div id="criminal-image-carousel" class="carousel slide col-xs-4 col-sm-4 col-md-4 col-lg-4 pull-left" data-ride="carousel">
          <!-- Indicators -->
          <ol class="carousel-indicators"></ol>
          <!-- Wrapper for slides -->
          <div class="carousel-inner" role="listbox"></div>
          <!-- Left and right controls -->
          <a class="left carousel-control" href="#criminal-image-carousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="right carousel-control" href="#criminal-image-carousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
        <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7 pull-right" id="criminal-data">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 description"></div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 reported-by"></div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 status"></div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 address"></div>
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 tags"></div>
        </div>
        <div style="clear: both;"></div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default pull-right" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<!-- footer -->
</main>
</div>
</div>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script>var baseUrl = "<?php echo URL;?>";</script>
<script>window.jQuery || document.write('<script src="<?php echo URL;?>js/jquery.min.js"><\/script>')</script>
<script src="<?php echo URL;?>js/tether.min.js"></script>
<script src="<?php echo URL;?>js/bootstrap.min.js"></script>
<script src="<?php echo URL;?>js/bootstrap-multiselect.js"></script>
<script src="<?php echo URL;?>js/common.js"></script>
<script src="<?php echo URL;?>js/jquery.dataTables.min.js"></script>
<script src="<?php echo URL;?>js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo URL;?>js/analysis.js"></script>
<script>
    $(document).ready(function() {
        $('#crime-list-table').DataTable();
    });
</script>
</body>
</html>
<?php
$conn->close();
?>