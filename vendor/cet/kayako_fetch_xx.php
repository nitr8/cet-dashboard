<?php
include 'config.inc.php'; 
include 'helper/mysql.php'; 

error_reporting(-1);
ini_set('display_errors', 'On');

$db = Database::obtain(KSQL_SERVER, KSQL_USER, KSQL_PASS, KSQL_DB);
$db->connect();

$reporttypeId = 1;
$weekNumber = date("W");
$yearNumber = date("Y");
if(isset($_GET['weeknumber']))
	$weekNumber = $_GET['weeknumber'];

if(isset($_GET['yearnumber']))
	$yearNumber = $_GET['yearnumber'];

if(isset($_GET['reporttypeId']))
	$reporttypeId = $_GET['reporttypeId'];
	
$weeknumberTo = $weekNumber+1;

$sqlQuery="select scfo.optionvalue as val, count(scfo.optionvalue) as cnt FROM ".KSQL_TPRFX."tickets tickets ";
$sqlQuery.="LEFT JOIN swcustomfieldvalues ON tickets.ticketid = swcustomfieldvalues.typeid LEFT JOIN swcustomfieldoptions scfo ON swcustomfieldvalues.fieldvalue = scfo.customfieldoptionId ";
$sqlQuery.="WHERE tickets.dateline > UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weekNumber." Monday', '%X%V %W')) ";
$sqlQuery.="AND tickets.dateline < UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weeknumberTo." Monday', '%X%V %W')) AND tickets.departmenttitle != 'IT'   AND tickets.departmenttitle != 'QFE' AND tickets.departmenttitle != 'OPS' AND tickets.departmenttitle != 'TimeTracking' AND scfo.customfieldid = 9 group by scfo.optionvalue";
$rows = $db->query($sqlQuery );
while ($record = $db->fetch($rows))
{
    $_result[] = $record;
}

$db->close();
echo "<hr>Connecting to ".MYSQL_SERVER.".";
$conn = @mysql_connect(MYSQL_SERVER,MYSQL_USER,MYSQL_PASS);
if(! $conn ) {
   die('Could not connect: ' . mysql_error());
}

echo "<hr>Selecting ".MYSQL_DB." on ".MYSQL_SERVER.". ";   
mysql_select_db(MYSQL_DB);

$sql = "Delete from ".MYSQL_DB.".Report where reportType =".$reporttypeId." AND weekNumber=".$weekNumber;
echo "<hr>Deleting reportype ".$reporttypeId." for week :".$weekNumber . "<br/>SQL: ".$sql;   

mysql_query( $sql, $conn );

$sql = "INSERT INTO ".MYSQL_DB.".Report(created,reportType,dateFrom,dateTo,weekNumber)VALUES(CURRENT_TIMESTAMP(),1,";
$sql .="STR_TO_DATE('".$yearNumber.$weekNumber." Monday', '%X%V %W')";
$sql .=",";
$sql .="STR_TO_DATE('".$yearNumber.$weeknumberTo." Monday', '%X%V %W')";
$sql .=",";
$sql .=$weekNumber;
$sql .=")";

echo "<hr>Inserting reportype ".$reporttypeId." for week :".$weekNumber . "<br/>SQL: ".$sql;   
$retval = mysql_query( $sql, $conn );
if(! $retval ) {
   die('Could not enter data: ' . mysql_error());
}

$reportID = mysql_insert_id();
echo "<hr>new ReportID:".$reportID;  
$_count = count($_result);
for($i=0; $i<$_count; $i++)
{
   $insSQL = "INSERT INTO ReportData (idReport,propertyName,value) VALUES(".$reportID.",'".$_result[$i]['val']."','".$_result[$i]['cnt']."')";
   $retval = mysql_query( $insSQL, $conn );
   print "INSERTING | ".$insSQL."</br>";
}
echo "<hr>Closing connection"; 
mysql_close($conn);
echo "<hr>Connection Closed";
?>