<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>CET-weeky-report-</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/inspinia/css/style.min.css" rel="stylesheet">
    <link href="vendor/chartist/css/chartist.min.css" rel="stylesheet">
  </head>
  <body class="top-navigation">
    <script src="vendor/jquery/jquery-2.1.1.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/metisMenu/jquery.metisMenu.js"></script>
    <script src="vendor/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="vendor/chartist/js/chartist.min.js"></script>
    <script src="vendor/flot/jquery.flot.js"></script>
    <script src="vendor/flot/jquery.flot.tooltip.min.js"></script>
    <script src="vendor/flot/jquery.flot.resize.js"></script>
    <script src="vendor/flot/jquery.flot.pie.js"></script>
    <script src="vendor/flot/jquery.flot.time.js"></script>
    <script src="vendor/cet/js/helper.js"></script>
    <div id="page-wrapper" class="gray-bg">
      <?php
        require __DIR__ . '/vendor/autoload.php';
        if (isset($_GET['page']) && strpos($_GET['page'], '_') !== false)
        {
          $tmp = $_GET['page'];
          include "content/".str_replace("_", "/", "$tmp").".php";
        }
        else
        {
          include "content/managment/lastweekreport.php";
        }
      ?>
    </div>
  </body>
</html>