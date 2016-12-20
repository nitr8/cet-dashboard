<?php

// autoload.php generated by Composer
#require __DIR__ . '/vendor/autoload.php';

include 'config.inc.php'; 
include 'helper/mysql.php'; 

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

$reporttypeId = "";
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

if ($reporttypeId > 0) {
	$db = Database::obtain(KSQL_SERVER,KSQL_USER, KSQL_PASS, KSQL_DB);
	$db->connect();

	switch ($reporttypeId)
	{
		case TICKETS_PER_PRODUCT :
			$sqlQuery="select scfo.optionvalue as val, count(scfo.optionvalue) as cnt FROM swtickets tickets ";
			$sqlQuery.="LEFT JOIN swcustomfieldvalues ON tickets.ticketid = swcustomfieldvalues.typeid LEFT JOIN swcustomfieldoptions  scfo ON swcustomfieldvalues.fieldvalue = scfo.customfieldoptionId ";
			$sqlQuery.="WHERE tickets.dateline > UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weekNumber." Monday', '%X%V %W')) ";
			$sqlQuery.="AND tickets.dateline < UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weeknumberTo." Monday', '%X%V %W')) ";
			$sqlQuery.="AND tickets.departmenttitle != 'IT' AND tickets.departmenttitle != 'QFE' AND tickets.departmenttitle != 'OPS' ";
			$sqlQuery.="AND tickets.departmenttitle != 'TimeTracking' AND tickets.departmenttitle != 'FE'  AND scfo.customfieldid = 9 group by scfo.optionvalue";
		break;
		
		case NEW_ISSUES_PER_PRODUCT :
			$sqlQuery="select ticketTypetitle as val , count(*) as cnt FROM swtickets tickets ";
			$sqlQuery.="LEFT JOIN swcustomfieldvalues ON tickets.ticketid = swcustomfieldvalues.typeid LEFT JOIN swcustomfieldoptions  scfo ON swcustomfieldvalues.fieldvalue = scfo.customfieldoptionId ";
			$sqlQuery.="WHERE tickets.dateline > UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weekNumber." Monday', '%X%V %W')) ";
			$sqlQuery.="AND tickets.dateline < UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weeknumberTo." Monday', '%X%V %W')) ";
			$sqlQuery.="AND tickets.departmenttitle != 'IT' AND tickets.departmenttitle != 'FE' AND tickets.departmenttitle != 'QFE' AND tickets.departmenttitle != 'OPS' ";
			$sqlQuery.="AND tickets.departmenttitle != 'TimeTracking' AND scfo.customfieldid = 9 group by ticketTypetitle";
		break;

		case AGED_CASES: //aged cases
			$sqlQuery.="SELECT swtickets.TicketID AS 'ID', swtickets.Ownerstaffname AS 'Owner', ";
			$sqlQuery.="from_unixtime(swtickets.dateline, '%Y %D %M %h:%i:%s') ";
			$sqlQuery.="As  ";
			$sqlQuery.="'Opened', swtickets.Subject AS 'Case', swtickets.firstresponsetime AS 'frt', swtickets.priorityTitle as 'pr',  ";
			$sqlQuery.="swtickets.AverageResponseTime AS 'ar', swtickets.TotalReplies AS 'tr',  ";
			$sqlQuery.="swtickets.TimeWorked AS 'tw', swtickets.ticketStatustitle AS 'Status',swuserorganizations.organizationname as 'on' ";
			$sqlQuery.="FROM swtickets ";
			$sqlQuery.="left join swusers on swtickets.userid = swusers.userid ";
			$sqlQuery.="left join swuserorganizations on swusers.userorganizationid = swuserorganizations.userorganizationid ";
			$sqlQuery.="WHERE swtickets.Departmenttitle ='CET' AND swtickets.ticketStatustitle != 'Closed'  ";
			$sqlQuery.="AND swtickets.ticketStatustitle != 'Resolved'  ";
			$sqlQuery.="AND swtickets.ticketStatustitle != 'On Hold'  ";
			$sqlQuery.="AND swtickets.dateline < UNIX_TIMESTAMP(curdate()-INTERVAL 7 DAY) ";
		break;
		
		case CLOSED_CASES: //closed cases
			$sqlQuery.="SELECT distinct swtickets.TicketID AS 'ID', swtickets.Ownerstaffname AS 'Owner', ";
			$sqlQuery.="from_unixtime(swtickets.dateline, '%Y %D %M %h:%i:%s') ";
			$sqlQuery.="As  ";
			$sqlQuery.="'Opened', swtickets.Subject AS 'Case', swtickets.firstresponsetime AS 'frt', swtickets.priorityTitle as 'pr', ";
			$sqlQuery.="swtickets.AverageResponseTime AS 'ar', swtickets.TotalReplies AS 'tr',  ";
			$sqlQuery.="swtickets.TimeWorked AS 'tw', swtickets.ticketStatustitle AS 'Status',swuserorganizations.organizationname as 'on' ";
			$sqlQuery.="FROM swtickets ";
			$sqlQuery.="left join swusers on swtickets.userid = swusers.userid ";
			$sqlQuery.="left join swuserorganizations on swusers.userorganizationid = swuserorganizations.userorganizationid ";		
			$sqlQuery.="LEFT JOIN swticketauditlogs on swtickets.ticketid=swticketauditlogs.ticketid ";
			$sqlQuery.="WHERE swtickets.Departmenttitle ='CET' ";
			$sqlQuery.="AND swticketauditlogs.dateline > UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weekNumber." Monday', '%X%V %W')) ";
			$sqlQuery.="AND swticketauditlogs.dateline < UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weeknumberTo." Monday', '%X%V %W')) ";
			$sqlQuery.="AND swticketauditlogs.actionmsg like 'Ticket status changed from:%to: Closed'";
		break;
		 
		case QFE_CLOSED: //closed cases
			$sqlQuery.="SELECT distinct swtickets.TicketID AS 'ID', swtickets.Ownerstaffname AS 'Owner', ";
			$sqlQuery.="from_unixtime(swtickets.dateline, '%Y %D %M %h:%i:%s') ";
			$sqlQuery.="As  ";
			$sqlQuery.="'Opened', swtickets.Subject AS 'Case', swtickets.firstresponsetime AS 'frt', swtickets.priorityTitle as 'pr',  ";
			$sqlQuery.="swtickets.AverageResponseTime AS 'ar', swtickets.TotalReplies AS 'tr',  ";
			$sqlQuery.="swtickets.TimeWorked AS 'tw', swtickets.ticketStatustitle AS 'Status', 'N/A' as 'on'";
			$sqlQuery.="FROM swtickets, swticketauditlogs ";
			$sqlQuery.="WHERE swtickets.Departmenttitle ='QFE' ";
			$sqlQuery.="AND swticketauditlogs.dateline > UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weekNumber." Monday', '%X%V %W')) ";
			$sqlQuery.="AND swticketauditlogs.dateline < UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weeknumberTo." Monday', '%X%V %W')) ";
			$sqlQuery.="AND swtickets.ticketid=swticketauditlogs.ticketid and swticketauditlogs.actionmsg like 'Ticket status changed from:%to: Closed'";
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
			$sqlQuery.="swtickets.TimeWorked AS 'tw', swtickets.ticketStatustitle AS 'Status', swuserorganizations.organizationname as 'on'";
			$sqlQuery.="FROM swtickets ";
			$sqlQuery.="left join swusers on swtickets.userid = swusers.userid ";
			$sqlQuery.="left join swuserorganizations on swusers.userorganizationid = swuserorganizations.userorganizationid ";		
			$sqlQuery.="WHERE swtickets.Departmenttitle ='CET' AND swtickets.isescalated = 1  ";
			$sqlQuery.="AND swtickets.dateline > UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weekNumber." Monday', '%X%V %W')) ";
			$sqlQuery.="AND swtickets.dateline < UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weeknumberTo." Monday', '%X%V %W')) ";

		break;
			case URGENT_CASES:
			$sqlQuery.="SELECT swtickets.TicketID AS 'ID', swtickets.Ownerstaffname AS 'Owner', ";
			$sqlQuery.="from_unixtime(swtickets.dateline, '%Y %D %M %h:%i:%s') ";
			$sqlQuery.="As  ";
			$sqlQuery.="'Opened', swtickets.Subject AS 'Case', swtickets.firstresponsetime AS 'frt', swtickets.priorityTitle as 'pr' , ";
			$sqlQuery.="swtickets.AverageResponseTime AS 'ar', swtickets.TotalReplies AS 'tr',  ";
			$sqlQuery.="swtickets.TimeWorked AS 'tw', swtickets.ticketStatustitle AS 'Status', swuserorganizations.organizationname as 'on' ";
			$sqlQuery.="FROM swtickets ";
			$sqlQuery.="left join swusers on swtickets.userid = swusers.userid ";
			$sqlQuery.="left join swuserorganizations on swusers.userorganizationid = swuserorganizations.userorganizationid ";		
			$sqlQuery.="WHERE swtickets.Departmenttitle ='CET' AND swtickets.priorityTitle = 'Urgent' ";
			$sqlQuery.="AND swtickets.dateline > UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weekNumber." Monday', '%X%V %W')) ";
			$sqlQuery.="AND swtickets.dateline < UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weeknumberTo." Monday', '%X%V %W')) ";
		break;
		
			case TOP_TEN_TIME_TAKERS:
			$sqlQuery.="select cv.fieldvalue as val, sum(swt.timespent) as cnt ";
			$sqlQuery.="from ";
			$sqlQuery.="swtickettimetracks swt, ";
			$sqlQuery.="swtickets t, ";
			$sqlQuery.="swcustomfieldvalues cv ";	
			$sqlQuery.="where ";
			$sqlQuery.="swt.ticketid = t.ticketid and ";
			$sqlQuery.="cv.customfieldid = 11 AND cv.typeid = t.ticketid AND ";
			$sqlQuery.="cv.fieldvalue in ";
			$sqlQuery.="(";
			$sqlQuery.="SELECT cv.fieldvalue customfieldvalue ";
			$sqlQuery.=" FROM swtickets           t, ";
			$sqlQuery.=" 	  swcustomfieldvalues cv ";
			$sqlQuery.="	   WHERE  cv.customfieldid = 11 ";
			$sqlQuery.="	   AND cv.typeid = t.ticketid ";
			$sqlQuery.="	   AND t.departmenttitle = 'OPS' ";
			$sqlQuery.="	   AND t.tickettypetitle = 'Daily Check' ";
			$sqlQuery.="	   AND t.ticketstatustitle <> 'Closed' ";
			$sqlQuery.="	ORDER BY customfieldvalue desc) ";
			$sqlQuery.=" AND ";
			$sqlQuery.=" swt.dateline > UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weekNumber." Monday', '%X%V %W')) ";
			$sqlQuery.="AND swt.dateline < UNIX_TIMESTAMP(STR_TO_DATE('".$yearNumber.$weeknumberTo." Monday', '%X%V %W')) ";
			$sqlQuery.=" group by cv.fieldvalue ";
			$sqlQuery.=" order by cnt desc limit 5 ";

		break;
		
	}

	$rows = $db->query($sqlQuery );

	while ($record = $db->fetch($rows))
	{
		$_result[] = $record;
	}

	$db->close();

	echo "Connecting to: ".MYSQL_USER."@".MYSQL_SERVER."<br/>Report ID: ".$reporttypeId." Week Number: ".$weekNumber."<hr>";

	$conn = @mysql_connect(MYSQL_SERVER,MYSQL_USER,MYSQL_PASS);

	if(! $conn ) 
	{
	die('Could not connect: ' . mysql_error());
	}
	
	mysql_select_db(MYSQL_DB);

	$sql = "DELETE FROM dashboard.Report WHERE reportType =".$reporttypeId." AND weekNumber=".$weekNumber;

	echo $sql;   

	mysql_query( $sql, $conn );

$sql = "INSERT INTO dashboard.Report(created,reportType,dateFrom,dateTo,weekNumber,yearNumber)VALUES(CURRENT_TIMESTAMP(),".$reporttypeId.",";
$sql .="STR_TO_DATE('".$yearNumber.$weekNumber." Monday', '%X%V %W')";
$sql .=",";
$sql .="STR_TO_DATE('".$yearNumber.$weeknumberTo." Monday', '%X%V %W')";
$sql .=",";
$sql .=$weekNumber;
$sql .=",";
$sql .=$yearNumber;
$sql .=")";


	echo "<hr>".$sql."<hr>";   
	$retval = mysql_query( $sql, $conn );
	if(! $retval ) {
	die('Could not enter data: ' . mysql_error());
	}

	$reportID = mysql_insert_id();
	echo "Report Data ID: ".$reportID."<br/>";   
	if(isset($_result))
	for($i=0; $i<count($_result); $i++)
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
			
			$insSQL = "INSERT INTO ReportDataForTicket (idReport,intValue1,intValue2,intValue3,intValue4,intValue5,stringValue1,stringValue2,stringValue3,stringValue4,stringValue5,stringValue6) ";
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
			$insSQL .="'".$_result[$i]['pr']."', ";
			$insSQL .="'".$_result[$i]['on']."') ";
			break;
		}	
		$retval = mysql_query( $insSQL, $conn );
		print $insSQL."</br> </br>";
	}
	mysql_close($conn);
} else {
        echo "<h2>kayako report fetcher</h2><br>Please specify report type and week to report on, e.g.:<br>https://swish.ifu.local/fetcher_kayako.php?reporttypeId=6&weekNumber=48";
}
?>