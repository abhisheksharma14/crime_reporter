        </main>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script>window.jQuery || document.write('<script src="../js/jquery.min.js"><\/script>')</script>
    <script src="../js/tether.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/bootstrap-multiselect.js"></script>
    <script src="../js/common.js"></script>
    <?php 
        if (strpos($url, "list.php")) {
            echo '<script src="../js/jquery.dataTables.min.js"></script><script src="../js/dataTables.bootstrap.min.js"></script>';
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