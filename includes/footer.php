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
    <?php 
        if (strpos($url, "list.php") || strpos($url, "analysis.php")) {
            echo '<script src="'.URL.'js/jquery.dataTables.min.js"></script><script src="'.URL.'js/dataTables.bootstrap.min.js"></script>';
            echo "<script>
                    $(document).ready(function() {
                        $('#crime-list-table').DataTable();
                    });
                </script>";   
        }
    ?>
  </body>
</html>
<?php
$conn->close();
?>