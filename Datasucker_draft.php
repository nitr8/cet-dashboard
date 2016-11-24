<?php
include 'vendor/cet/config.inc.php'; 
include 'vendor/cet/helper/mysql.php'; 

define('TICKETS_PER_PRODUCT','1');
define('TOP_TEN_TIME_TAKERS','2');
define('AGED_CASES','3');
define('URGENT_CASES','4');
define('SLA_BROKEN','5');
define('MANAGED_MIGRATIONS','6');
define('QFE_FIXES_PER_PRODUCT','7');
define('QFE_CLOSED','8');
define('NEW_ISSUES_PER_PRODUCT','9');
define('CLOSED_CASES','10');

error_reporting(-1);
ini_set('display_errors', 'On');


$db = Database::obtain(KSQL_SERVER,KSQL_USER, KSQL_PASS, KSQL_DB);
$db->connect();

$reporttypeId = 1;
$weekNumber = date("W");
$yearNumber = date("Y");
if(isset($_GET['weekNumber']))
	$weekNumber = $_GET['weekNumber'];

if(isset($_GET['yearnumber']))
	$yearNumber = $_GET['yearnumber'];

if(isset($_GET['reporttypeId']))
	$reporttypeId = $_GET['reporttypeId'];

$weeknumberTo = $weekNumber+1;

$sqlQuery ="";

switch ($reporttypeId)
{
	case TICKETS_PER_PRODUCT :
		$sqlQuery="select scfo.optionvalue as val, count(scfo.optionvalue) as cnt FROM swtickets tickets ";
		$sqlQuery.="LEFT JOIN swcustomfieldvalues ON tickets.ticketid = swcustomfieldvalues.typeid LEFT JOIN swcustomfieldoptions  scfo ON swcustomfieldvalues.fieldvalue = scfo.customfieldoptionId ";
		$sqlQuery.="WHERE tickets.dateline > UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weekNumber." Monday', '%X%V %W')) ";
		$sqlQuery.="AND tickets.dateline < UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weeknumberTo." Monday', '%X%V %W')) ";
		$sqlQuery.="AND tickets.departmenttitle != 'IT'   AND tickets.departmenttitle != 'QFE' AND tickets.departmenttitle != 'OPS' ";
		$sqlQuery.="AND tickets.departmenttitle != 'TimeTracking'    AND scfo.customfieldid = 9 group by scfo.optionvalue";
	break;
	
	case NEW_ISSUES_PER_PRODUCT :
		$sqlQuery="select ticketTypetitle as val , count(*) as cnt FROM swtickets tickets ";
		$sqlQuery.="LEFT JOIN swcustomfieldvalues ON tickets.ticketid = swcustomfieldvalues.typeid LEFT JOIN swcustomfieldoptions  scfo ON swcustomfieldvalues.fieldvalue = scfo.customfieldoptionId ";
		$sqlQuery.="WHERE tickets.dateline > UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weekNumber." Monday', '%X%V %W')) ";
		$sqlQuery.="AND tickets.dateline < UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weeknumberTo." Monday', '%X%V %W')) ";
		$sqlQuery.="AND tickets.departmenttitle != 'IT'   AND tickets.departmenttitle != 'QFE' AND tickets.departmenttitle != 'OPS' ";
		$sqlQuery.="AND tickets.departmenttitle != 'TimeTracking'    AND scfo.customfieldid = 9 group by ticketTypetitle";
	break;

	case AGED_CASES: //aged cases
		$sqlQuery.="SELECT swtickets.TicketID AS 'ID', swtickets.Ownerstaffname AS 'Owner', ";
		$sqlQuery.="from_unixtime(swtickets.dateline, '%Y %D %M %h:%i:%s') ";
		$sqlQuery.="As  ";
		$sqlQuery.="'Opened', swtickets.Subject AS 'Case', swtickets.firstresponsetime AS 'frt', swtickets.priorityTitle as 'pr',  ";
		$sqlQuery.="swtickets.AverageResponseTime AS 'ar', swtickets.TotalReplies AS 'tr',  ";
		$sqlQuery.="swtickets.TimeWorked AS 'tw', swtickets.ticketStatustitle AS 'Status' ";
		$sqlQuery.="FROM swtickets ";
		$sqlQuery.="WHERE swtickets.Departmenttitle ='CET' AND swtickets.ticketStatustitle != 'Closed'  ";
		$sqlQuery.="AND swtickets.ticketStatustitle != 'Resolved'  ";
		$sqlQuery.="AND swtickets.ticketStatustitle != 'On Hold'  ";
		$sqlQuery.="AND swtickets.dateline < UNIX_TIMESTAMP(curdate()-INTERVAL 7 DAY) ";
	break;
	
	case CLOSED_CASES: //closed cases
		$sqlQuery.="SELECT swtickets.TicketID AS 'ID', swtickets.Ownerstaffname AS 'Owner', ";
		$sqlQuery.="from_unixtime(swtickets.dateline, '%Y %D %M %h:%i:%s') ";
		$sqlQuery.="As  ";
		$sqlQuery.="'Opened', swtickets.Subject AS 'Case', swtickets.firstresponsetime AS 'frt', swtickets.priorityTitle as 'pr', ";
		$sqlQuery.="swtickets.AverageResponseTime AS 'ar', swtickets.TotalReplies AS 'tr',  ";
		$sqlQuery.="swtickets.TimeWorked AS 'tw', swtickets.ticketStatustitle AS 'Status' ";
		$sqlQuery.="FROM swtickets ";
		$sqlQuery.="WHERE swtickets.Departmenttitle ='CET' AND swtickets.ticketStatustitle = 'Closed'  ";
		$sqlQuery.="AND swtickets.dateline > UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weekNumber." Monday', '%X%V %W')) ";
		$sqlQuery.="AND swtickets.dateline < UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weeknumberTo." Monday', '%X%V %W')) ";
	break;
	
	case QFE_CLOSED: //closed cases
		$sqlQuery.="SELECT swtickets.TicketID AS 'ID', swtickets.Ownerstaffname AS 'Owner', ";
		$sqlQuery.="from_unixtime(swtickets.dateline, '%Y %D %M %h:%i:%s') ";
		$sqlQuery.="As  ";
		$sqlQuery.="'Opened', swtickets.Subject AS 'Case', swtickets.firstresponsetime AS 'frt', swtickets.priorityTitle as 'pr',  ";
		$sqlQuery.="swtickets.AverageResponseTime AS 'ar', swtickets.TotalReplies AS 'tr',  ";
		$sqlQuery.="swtickets.TimeWorked AS 'tw', swtickets.ticketStatustitle AS 'Status' ";
		$sqlQuery.="FROM swtickets ";
		$sqlQuery.="WHERE swtickets.Departmenttitle ='QFE' AND swtickets.ticketStatustitle = 'Closed'  ";
		$sqlQuery.="AND swtickets.dateline > UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weekNumber." Monday', '%X%V %W')) ";
		$sqlQuery.="AND swtickets.dateline < UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weeknumberTo." Monday', '%X%V %W')) ";
	break;
	
	case MANAGED_MIGRATIONS:
		$sqlQuery.="select scfo.optionvalue as val, count(scfo.optionvalue) as cnt ";
		$sqlQuery.="FROM swtickets tickets  ";
		$sqlQuery.="LEFT JOIN swcustomfieldvalues ON tickets.ticketid = swcustomfieldvalues.typeid ";
		$sqlQuery.="LEFT JOIN swcustomfieldoptions  scfo ON swcustomfieldvalues.fieldvalue = scfo.customfieldoptionId ";
		$sqlQuery.="WHERE ";
		$sqlQuery.="tickets.departmenttitle = 'OPS' ";
		$sqlQuery.="and tickets.ticketstatustitle ='Daily Checks' ";
		$sqlQuery.="AND scfo.customfieldid = 9  group by scfo.optionvalue  ";
	break;

	case QFE_FIXES_PER_PRODUCT : //qfe fixes per roduct
		$sqlQuery.="select scfo.optionvalue as 'val', count(scfo.optionvalue) as 'cnt' ";
		$sqlQuery.="FROM swtickets tickets  ";
		$sqlQuery.="LEFT JOIN swcustomfieldvalues ON tickets.ticketid = swcustomfieldvalues.typeid ";
		$sqlQuery.="LEFT JOIN swcustomfieldoptions  scfo ON swcustomfieldvalues.fieldvalue = scfo.customfieldoptionId ";
		$sqlQuery.="WHERE   ";
		$sqlQuery.=" tickets.dateline > UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weekNumber." Monday', '%X%V %W')) ";
		$sqlQuery.="AND tickets.dateline < UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weeknumberTo." Monday', '%X%V %W')) ";
		$sqlQuery.="   AND tickets.departmenttitle = 'QFE' ";
		$sqlQuery.="   AND scfo.customfieldid = 9 group by scfo.optionvalue ";
	break;
	
	case SLA_BROKEN:
		$sqlQuery.="SELECT swtickets.TicketID AS 'ID', swtickets.Ownerstaffname AS 'Owner', ";
		$sqlQuery.="from_unixtime(swtickets.dateline, '%Y %D %M %h:%i:%s') ";
		$sqlQuery.="As  ";
		$sqlQuery.="'Opened', swtickets.Subject AS 'Case', swtickets.firstresponsetime AS 'frt', swtickets.priorityTitle as 'pr' , ";
		$sqlQuery.="swtickets.AverageResponseTime AS 'ar', swtickets.TotalReplies AS 'tr',  ";
		$sqlQuery.="swtickets.TimeWorked AS 'tw', swtickets.ticketStatustitle AS 'Status' ";
		$sqlQuery.="FROM swtickets ";
		$sqlQuery.="WHERE swtickets.Departmenttitle ='CET' AND swtickets.isescalated = 1   AND swtickets.ticketStatustitle <> 'Closed' ";
		$sqlQuery.="AND swtickets.dateline > UNIX_TIMESTAMP(curdate()-INTERVAL 7 DAY) ";

	break;
		case URGENT_CASES:
		$sqlQuery.="SELECT swtickets.TicketID AS 'ID', swtickets.Ownerstaffname AS 'Owner', ";
		$sqlQuery.="from_unixtime(swtickets.dateline, '%Y %D %M %h:%i:%s') ";
		$sqlQuery.="As  ";
		$sqlQuery.="'Opened', swtickets.Subject AS 'Case', swtickets.firstresponsetime AS 'frt', swtickets.priorityTitle as 'pr' , ";
		$sqlQuery.="swtickets.AverageResponseTime AS 'ar', swtickets.TotalReplies AS 'tr',  ";
		$sqlQuery.="swtickets.TimeWorked AS 'tw', swtickets.ticketStatustitle AS 'Status' ";
		$sqlQuery.="FROM swtickets ";
		$sqlQuery.="WHERE swtickets.Departmenttitle ='CET'  AND swtickets.ticketStatustitle <> 'Closed' AND  swtickets.priorityTitle = 'Urgent' ";
	break;
	
		case TOP_TEN_TIME_TAKERS:
		$sqlQuery.="select svo.organizationname as val,sum(tickets.timeworked) as cnt ";
		$sqlQuery.="FROM swtickets tickets  ";
		$sqlQuery.="LEFT JOIN swusers svu on tickets.userid = svu.userid ";
		$sqlQuery.="LEFT JOIN swuserorganizations svo on svu.userorganizationid = svo.userorganizationid ";
		$sqlQuery.="group by svo.organizationname order by cnt desc";
 

	break;
	
}
//echo "<hr>".$sqlQuery."<hr>";

$rows = $db->query($sqlQuery );

while ($record = $db->fetch($rows))
{
    $_result[] = $record;
}

$db->close();

echo "<hr>Connecting to 139.162.176.38";

$conn = @mysql_connect("localhost","root","toor");

if(! $conn ) 
{
   die('Could not connect: ' . mysql_error());
}

echo "<hr>Selecting DB to LUZD on 139.162.176.38";   

mysql_select_db('dashboard');

$sql = "Delete from dashboard.Report where reportType =".$reporttypeId." AND weekNumber=".$weekNumber;

echo "<hr>Deleting reportype ".$reporttypeId." for week :".$weekNumber . "<br/>SQL: ".$sql;   

mysql_query( $sql, $conn );

$sql = "INSERT INTO dashboard.Report(created,reportType,dateFrom,dateTo,weekNumber)VALUES(CURRENT_TIMESTAMP(),".$reporttypeId.",";
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
	switch ($reporttypeId)
	{
		case TICKETS_PER_PRODUCT:
		case NEW_ISSUES_PER_PRODUCT:
		case MANAGED_MIGRATIONS:
		case QFE_FIXES_PER_PRODUCT:
		case TOP_TEN_TIME_TAKERS:
			$insSQL = "INSERT INTO ReportData (idReport,propertyName,value) VALUES(".$reportID.",'".$_result[$i]['val']."','".$_result[$i]['cnt']."')";
		break;
		
		case AGED_CASES:
		case QFE_CLOSED:
		case CLOSED_CASES:
		case SLA_BROKEN:
		case URGENT_CASES:
		
		$insSQL = "INSERT INTO ReportDataForTicket (idReport,intValue1,intValue2,intValue3,intValue4,intValue5,stringValue1,stringValue2,stringValue3,stringValue4,stringValue5) ";
		$insSQL .="VALUES (".$reportID.",";
		$insSQL .=$_result[$i]['ID'].", ";
		$insSQL .=$_result[$i]['frt'].", ";
		$insSQL .=$_result[$i]['ar'].", ";
		$insSQL .=$_result[$i]['tr'].", ";
		$insSQL .=$_result[$i]['tw'].", ";
	
		$insSQL .="'".$_result[$i]['Owner']."', ";
		$insSQL .="'".$_result[$i]['Opened']."', ";
		$insSQL .="'".$_result[$i]['Case']."', ";
		$insSQL .="'".$_result[$i]['Status']."', ";
			$insSQL .="'".$_result[$i]['pr']."') ";
		break;
	}
	   
	$retval = mysql_query( $insSQL, $conn );
	print "INSERTING | ".$insSQL."</br>";
}

echo "<hr>Closing connection"; 

mysql_close($conn);

echo "<hr>Connection Closed";

?>