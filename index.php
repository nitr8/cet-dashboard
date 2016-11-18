<?php 
session_start();
 
include 'vendor/cet/config.inc.php'; 
include 'vendor/cet/helper/mysql.php'; 
include 'vendor/cet/helper/others.php';
include 'vendor/cet/wrapper/customer.php';
include 'vendor/cet/wrapper/link.php';

error_reporting(-1);

ini_set('display_errors', 'On');
$db = Database::obtain(KSQL_SERVER, KSQL_USER, KSQL_PASS, KSQL_DB);
$db->connect();

$userName ="";
$pwd = "";;
if($_POST){ 
  $_SESSION['username']=$_POST["username"]; 
  $_SESSION['password']=$_POST["password"];   
} 
if (isset( $_SESSION['username'])) 
  $userName=$_SESSION['username'];
  
if (isset( $_SESSION['password'])) 
  $pwd=$_SESSION['password'];
  
if (isset($_GET['page']) && $_GET['page'] =="logout")
{
  $userName ="";
  $pwd = "";;
  session_destroy(); 
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUADROtech dashboard</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="vendor/animate/animate.min.css" rel="stylesheet">
    <link href="vendor/inspinia/css/style.min.css" rel="stylesheet">
    <link href="vendor/picker/css/datepicker.css" rel="stylesheet">
    <link href="vendor/chartist/css/chartist.min.css" rel="stylesheet">
  </head>
 
  <body class="top-navigation">
  <script src="vendor/jquery/jquery-2.1.1.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  
  <script src="vendor/metisMenu/jquery.metisMenu.js"></script>
  <script src="vendor/slimscroll/jquery.slimscroll.min.js"></script>

  <script src="vendor/inspinia/js/inspinia.js"></script>
  <script src="vendor/pace/pace.min.js"></script>
  <script src="vendor/picker/js/datepicker.js"></script>
  <script src="vendor/chartist/js/chartist.min.js"></script>
  <script src="vendor/flot/jquery.flot.js"></script>
  <script src="vendor/flot/jquery.flot.tooltip.min.js"></script>
  <script src="vendor/flot/jquery.flot.resize.js"></script>
  <script src="vendor/flot/jquery.flot.pie.js"></script>
  <script src="vendor/flot/jquery.flot.time.js"></script>


  <div id="page-wrapper" class="gray-bg">
 
    <div class="row white-bg">
 
      <nav class="navbar navbar-static-top" role="navigation">
 
        <div class="navbar-header">
          <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
            <i class="fa fa-reorder"></i>
          </button>
          <a href="?page=home" class="navbar-brand">CET</a>
        </div>

        <?php if (authenticateUser($userName,$pwd)) { ?>  

        <div class="navbar-collapse collapse" id="navbar">
        
          <ul class="nav navbar-nav">
        
            <li class="<?php isActive("Support");?>">
              <a aria-expanded="false" role="button" href="?page=sup_overview"> SUP </a>
            </li>
          
            <li class="<?php isActive("QFE");?>">
              <a aria-expanded="false" role="button" href="?page=qfe_overview"> QFE </a>
            </li>

            <li class="dropdown <?php isActive("ManagedMigrations");?>">
              <a aria-expanded="false" role="button" href="?page=ops_overview"> OPS 
                <span class="caret"></span>
              </a>
              <ul role="menu" class="dropdown-menu">
                <li>
                 <a href="?page=ops_list">List of Customers</a>
                </li>
                <?php
                foreach(GetAllCustomers($db) as $record)
                {
                  echo ("<li><a href=\"?page=ops_migration&CustomerID=".$record['CustomerId']."\">".$record['CustomerName']."</a></li>");
                }
                ?>
                </ul>
            </li>
   
            <li class="dropdown <?php isActive("ManagedMigrations");?>">
              <a aria-expanded="false" role="button" href="?page=managment_overview"> Management </a>
            </li>

            <li class="dropdown">
              <a class="dropdown-toggle" role="button" aria-expanded="false" href="#" data-toggle="dropdown" href="?page=reports_list"> Reports 
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <?php
                  $sql = "SELECT * FROM ".MYSQL_DB.".ReportType";// Create connection
                  $conn = @mysql_connect(MYSQL_SERVER,MYSQL_USER,MYSQL_PASS);
                  mysql_select_db(MYSQL_DB);
                  $retval = mysql_query( $sql, $conn );

                  while ($row = mysql_fetch_array($retval))
                  {
                    echo ("<li><a href=\"?page=reports_list&reportTypeID=".$row['idReportType']."\">".$row['ReportTypeName']."</a></li>");
                  }
                ?>
              </ul>
            </li>

          </ul>

          <ul class="nav navbar-top-links navbar-right">
        
            <li>
              <a href="?page=logout">
                <i class="fa fa-sign-out"></i> Log out (<?php if (USE_AUTH) echo $userName; ?>)
              </a>
            </li>
        
          </ul>
        
        </div>

        <?php } ?>

      </nav>

    </div>
  
    <?php
    if (authenticateUser($userName,$pwd))
    {
      if (isset($_GET['page']) && strpos($_GET['page'], '_') !== false)
      {
        $tmp = $_GET['page'];
        include "content/".str_replace("_", "/", "$tmp").".php";
      }
      else
      {
        include "content/home.php";
      }
    }
    else
    {
      if (isset($_GET['page']) && $_GET['page']== "_")
      {
        $tmp = $_GET['page'];
        include "content/".str_replace("_", "/", "$tmp").".php";
      }
      else
      {
        include "content/login.php";
      }
    }
    
    ?>


  </div>
  </body>

</html>