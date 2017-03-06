<?php 
  
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// autoload.php generated by Composer
require __DIR__ . '/vendor/autoload.php';


function showTimezone ($header,$tzName)
{
$datetime = new DateTime; // current time = server time
$otherTZ  = new DateTimeZone($tzName);
$datetime->setTimezone($otherTZ); // calculates with new TZ now
return 
"<div style=\"font-size:9px;\">".
$header."</div>".

"<div style=\"font-size:8px;\">".
$tzName."</div><hr style=\"padding:0;margin:0;\">"
."<b>".
date_format($datetime, 'H:i')."</b>";
}
/////////////////////////////////////////////
//Bamboo HR stuff 
$displayBamboo = true;
$dateFromBamboo = date("Y-m-d");
$dateToBamboo = date("Y-m-d", strtotime("+30 day", time()));

include "BambooHR/API/API.php";
use \BambooHR\API\BambooAPI as BHR;
if($displayBamboo){
$api = new BHR(BAMBOO_COMPANY);
$api->setSecretKey(BAMBOO_SECRET);
$authenticated = $api->login(BAMBOO_SECRET, BAMBOO_LOGIN,BAMBOO_PWD);


$parameter=array("status" => "approved","start"=>date("Y-m-d"),"end"=>$dateToBamboo);
$response = $api->getTimeOffRequestsArr($parameter);
}
/////////////////////////////////////////////

$_currentdate = datetoday();
$_departmentid = 3;
$_categories = '';

$_due = '';
$_nondue = '';

ini_set('display_errors', 'On');
$db = Database::obtain(KSQL_SERVER, KSQL_USER, KSQL_PASS, KSQL_DB);
$db->connect();
$_row = $db->query_first("SELECT customfieldid FROM ".KSQL_TPRFX."customfields WHERE title = 'Product'");
if( empty($_row) ){
    
    echo "No custom fields found. Please contact Administrator.";
    exit;
}
$_custfieldid = $_row['customfieldid'];

unset($_row);
$_row = array();

$rows = $db->query("SELECT customfieldoptionid, optionvalue FROM ".KSQL_TPRFX."customfieldoptions WHERE customfieldid = $_custfieldid");
while ($record = $db->fetch($rows))
{
    $_row[] = $record;
}

if(!empty($_row)){
    $_count = count($_row);    
}

if((!empty($_count) AND $_count != 0)){
    $_custgrpoptions = $_row;
    unset($_row);
    $_row = array();
}
$tmp = array();
if(!empty($_custgrpoptions))
{
    for($i = 0; $i < $_count; $i++)
    {
        $rows = $db->query("SELECT count(".KSQL_TPRFX."tickets.ticketid) as cnt FROM ".KSQL_TPRFX."tickets LEFT JOIN ".KSQL_TPRFX."customfieldvalues ON ".KSQL_TPRFX."tickets.ticketid = ".KSQL_TPRFX."customfieldvalues.typeid WHERE ((".KSQL_TPRFX."tickets.duetime <= ".$_currentdate." AND ".KSQL_TPRFX."tickets.duetime != '0') OR (".KSQL_TPRFX."tickets.resolutionduedateline <= ".$_currentdate." AND ".KSQL_TPRFX."tickets.resolutionduedateline != '0')) AND ".KSQL_TPRFX."tickets.isescalatedvolatile = '0' AND ".KSQL_TPRFX."tickets.isresolved = '0' AND ".KSQL_TPRFX."tickets.ticketstatustitle != 'Closed' AND ".KSQL_TPRFX."customfieldvalues.fieldvalue = ".$_custgrpoptions[$i]['customfieldoptionid']." AND ".KSQL_TPRFX."customfieldvalues.customfieldid = ".$_custfieldid." AND ".KSQL_TPRFX."tickets.departmentid = ".$_departmentid);
        while ($record = $db->fetch($rows))
        {
           $_row[] = $record;
        }
        // Assign the value to $_custgrpoptions array
        $_custgrpoptions[$i]['due'] = $_row[$i]['cnt'];
    }
    unset($_row);
    $_row = array();
    
    // Non-Due tickets
    for($i = 0; $i < $_count; $i++)
    {
        $rows = $db->query("SELECT count(".KSQL_TPRFX."tickets.ticketid) as cnt FROM ".KSQL_TPRFX."tickets LEFT JOIN ".KSQL_TPRFX."customfieldvalues ON ".KSQL_TPRFX."tickets.ticketid = ".KSQL_TPRFX."customfieldvalues.typeid WHERE (".KSQL_TPRFX."tickets.duetime >= ".$_currentdate." OR ".KSQL_TPRFX."tickets.duetime = '0') AND ".KSQL_TPRFX."tickets.isescalatedvolatile = '0' AND ".KSQL_TPRFX."tickets.isresolved = '0' AND ".KSQL_TPRFX."tickets.ticketstatustitle != 'Closed' AND ".KSQL_TPRFX."customfieldvalues.fieldvalue = ".$_custgrpoptions[$i]['customfieldoptionid']." AND ".KSQL_TPRFX."customfieldvalues.customfieldid = ".$_custfieldid." AND ".KSQL_TPRFX."tickets.departmentid = ".$_departmentid);
        while ($record = $db->fetch($rows))
        {
            $_row[] = $record;
        }
        
        // Assign the value to $_custgrpoptions array
        $_custgrpoptions[$i]['nondue'] = $_row[$i]['cnt'];
    }

     for($i = 0; $i < $_count; $i++)
	 {
      if ($_custgrpoptions[$i]['optionvalue']=="ArchiveShuttle.cloud") {$tmp['asc_d'] = $_custgrpoptions[$i]['due'];$tmp['asc_nd'] = $_custgrpoptions[$i]['nondue'];}
	  else 
		if ($_custgrpoptions[$i]['optionvalue']=="ArchiveShuttle") {$tmp['as_d'] = $_custgrpoptions[$i]['due'];$tmp['as_nd'] = $_custgrpoptions[$i]['nondue'];}
			else
				if ($_custgrpoptions[$i]['optionvalue']=="MailboxShuttle.cloud"){$tmp['msc_d'] = $_custgrpoptions[$i]['due'];$tmp['msc_nd'] = $_custgrpoptions[$i]['nondue'];}
					else
					if  ($_custgrpoptions[$i]['optionvalue']=="MailboxShuttle"){$tmp['ms_d'] = $_custgrpoptions[$i]['due'];$tmp['ms_nd'] = $_custgrpoptions[$i]['nondue'];} 
	  else
		if($i == ($_count - 1))
		{
            // Last result
            $_categories .= "'".$_custgrpoptions[$i]['optionvalue']."'";
            $_due .= $_custgrpoptions[$i]['due'];
            $_nondue .= $_custgrpoptions[$i]['nondue'];
            
        }else{
            // Other results
            $_categories .= "'".$_custgrpoptions[$i]['optionvalue']."', ";
            $_due .= $_custgrpoptions[$i]['due'].", ";
            $_nondue .= $_custgrpoptions[$i]['nondue'].", ";                    
        }
    }
    
}

$_categories = "'Mailbox Shuttle', " .$_categories;
$_categories = "'Archive Shuttle', " .$_categories;
$_due = ($tmp['msc_d'] + $tmp['ms_d']).", ".$_due;
$_nondue = ($tmp['msc_nd'] + $tmp['ms_nd']).", ".$_nondue;
$_due = ($tmp['asc_d'] + $tmp['as_d']).", ".$_due;
$_nondue = ($tmp['asc_nd'] + $tmp['as_nd']).", ".$_nondue;
 
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QUADROtech dashboard
    </title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/chartist/css/chartist.min.css" rel="stylesheet">
    <link href="vendor/bigscreendisplay/bsd.min.css" rel="stylesheet">
  </head>
  <body class="top-navigation"  onload="setTimeout('document.location.reload();', 60000);">
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
	
<div id="page-wrapper" class="gray-bg">
    <div class="row" >
        <div class="col-sm-3">
             <div class="dashboardcounter" style="background-color:#1c84c6 ">
                 <div class="dashboardcounterparent">
                     <?php $ticketCount = $db->getTicketCountforStatus('Open','CET');?>
                     <div class="dashboardcounterheader">Open</div>
                     <div class="dashboardcounternumber"><?php echo $ticketCount?></div>
                 </div>
            </div>
            <div class="dashboardcounter" style="background-color:#1AB394">
                 <div class="dashboardcounterparent">
                     <?php $ticketCount = $db->getTicketCountforStatus('In Progress','CET');?>
                     <div class="dashboardcounterheader">In Progress</div>
                     <div class="dashboardcounternumber"><?php echo $ticketCount?></div>
                 </div>
            </div>
            <div class="dashboardcounter" style="background-color:#79D2C0">
                 <div class="dashboardcounterparent">
                     <?php $ticketCount = $db->getTicketCountforStatus('Pending','CET');?>
                     <div class="dashboardcounterheader">Pending</div>
                     <div class="dashboardcounternumber"><?php echo $ticketCount?></div>
                 </div>
            </div>
			<div class="dashboardcounter" style="background-color:Orchid">
                 <div class="dashboardcounterparent">
                     <?php $ticketCount = $db->getTicketCountforStatus('On Hold','CET');?>
                     <div class="dashboardcounterheader">On Hold</div>
                     <div class="dashboardcounternumber"><?php echo $ticketCount?></div>
                 </div>
            </div>
		</div>
		  <div class="col-sm-7" style="text-align:center;"> 
			<div style="padding-top:20px">
			<table width="100%">
			<tr>
				<td width="13%"><?php echo showTimeZone("Pacific","America/Los_Angeles");?></td>				
				<td width="13%"><?php echo showTimeZone("Mountain","America/Denver");?></td>
				<td width="13%"><?php echo showTimeZone("Central","America/Chicago");?></td>
				<td width="13%"><?php echo showTimeZone("Eastern","America/New_York");?></td>
				<td width="13%"><?php echo showTimeZone("CET","Europe/Bratislava");?></td>
				<td width="13%"><?php echo showTimeZone("Eastern","Asia/Hong_Kong");?></td>
				<td width="13%"><?php echo showTimeZone("Eastern","Australia/Sydney");?></td>
				</table>
			</div>
		  </div>
		<div class="col-sm-2" >
            <div class="dashboardcounter" style="background-color:gold;float:right;">
                 <div class="dashboardcounterparent">
                     <?php $ticketCount = $db->getTicketCountforStatus('Closed','CET');?>
                     <div class="dashboardcounterheader">Closed</div>
                     <div class="dashboardcounternumber"><?php echo $ticketCount?></div>
                 </div>
            </div>
			 <div class="dashboardcounter" style="background-color:DarkKhaki;float:right;">
                 <div class="dashboardcounterparent">
                     <?php $ticketCount = $db->getTicketCountforStatus('Resolved','CET');?>
                     <div class="dashboardcounterheader">Resolved</div>
                     <div class="dashboardcounternumber"><?php echo $ticketCount?></div>
                 </div>
            </div>
		</div>
	</div>
    <div class="row">
                <div class="col-sm-8" style="padding:4px">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                        <h3>Tickets by product</h3>

                        </div>
                        <div class="ibox-content" style="height:200px">
                            <div id="ct-chart3" ></div>
                        </div>
                    </div>
                </div>
				 <div class="col-sm-4" style="padding:4px">
			  <div class="ibox float-e-margins" >
				<div class="ibox-title">
				<h3>Ticket breakdown</h3>
				
				</div>
				<div class="ibox-content" style="height:200px">
				<?php
					echo "<table cellpadding=\"2\" cellspacing=\"1\" border=\"0\" style=\"width: 100%\"><tr>";
			
				for($i = 0; $i < $_count; $i++)
				{
				echo "<td>".$_custgrpoptions[$i]['optionvalue']."</td>";
				echo  "<td>".$_custgrpoptions[$i]['nondue']."</td>";
				echo "<td ";
				
				if ($_custgrpoptions[$i]['due']!=0) 
					echo "style=\"color:red;\"";
				echo ">".$_custgrpoptions[$i]['due']."</td></tr>";
			
				}?>
				</table>
				</div></div></div>
	</div>
    <div class="row">
		<div class="col-sm-4" style="padding:4px">
			<?php
			$query ="SELECT ticketid, subject, ownerstaffname, prioritytitle FROM ".KSQL_TPRFX."tickets LEFT JOIN ".KSQL_TPRFX."customfieldvalues ON ".KSQL_TPRFX."tickets.ticketid = ".KSQL_TPRFX."customfieldvalues.typeid WHERE ((".KSQL_TPRFX."tickets.duetime <= ".$_currentdate." AND ".KSQL_TPRFX."tickets.duetime != '0') OR (".KSQL_TPRFX."tickets.resolutionduedateline <= ".$_currentdate." AND ".KSQL_TPRFX."tickets.resolutionduedateline != '0')) AND ".KSQL_TPRFX."tickets.isescalatedvolatile = '0' AND ".KSQL_TPRFX."tickets.isresolved = '0' AND ".KSQL_TPRFX."tickets.ticketstatustitle != 'Closed' AND ".KSQL_TPRFX."customfieldvalues.customfieldid = ".$_custfieldid." AND ".KSQL_TPRFX."tickets.departmentid = ".$_departmentid;
			generateBox($db,"Overdue tickets",$query, array("ticketid","ownerstaffname","subject","prioritytitle"),array("ID","Owner","Subject","PriorityIconSmall"),true,220,false,3,9,60) ;
	
			$_startdate = time();
			$_enddate = time() + 604800; // 7 days
			$_startdate = date('d/m/Y', $_startdate);
			$_enddate = date('d/m/Y', $_enddate);
			?>
			 <div class="ibox float-e-margins" >
				<div class="ibox-title">
				<h3>Approved time off from <?php echo (date("jS F", strtotime($dateFromBamboo))." to ".date("jS F", strtotime($dateToBamboo) ));?></h3>
				
				</div>
				<div class="ibox-content" style="height:280px">
                <?php
				if($displayBamboo)	
					echo generateDayOffBoxFromResponse($response);
				?>
                  </div>
			</div>
        </div>
        <div class="col-sm-4" style="padding:4px"> 
			<?php
			$query ="SELECT ticketid, subject,prioritytitle FROM ".KSQL_TPRFX."tickets WHERE ticketstatustitle = 'Open' AND departmenttitle='CET' ORDER BY dateline DESC";
			generateBox($db,"Open tickets",$query, array("ticketid","subject","prioritytitle"),array("ID","Subject","PriorityIconSmall"),true,220,false,3,9,60) ;

			$query ="SELECT  kbarticleid, subject, from_unixtime(editeddateline, '%d-%m-%Y') as edited FROM ".KSQL_TPRFX."kbarticles where editeddateline< UNIX_TIMESTAMP(DATE_SUB(NOW(),INTERVAL 1 YEAR)) order by editeddateline desc";
			generateBox($db,"KB articles older than year",$query, array("kbarticleid","subject", "edited"),array("ID","Subject","Modified"),true,280,false,3,12,60) ;
			?>
			</div>
            <div class="col-sm-4" style="padding:4px">
			<?php 
			$query ="SELECT ticketid, subject, prioritytitle FROM ".KSQL_TPRFX."tickets WHERE ownerstaffid = 0 AND ticketstatustitle = 'Open' AND departmentid = $_departmentid ORDER BY dateline DESC";
			generateBox($db,"Unassigned tickets",$query, array("ticketid","subject","prioritytitle"),array("ID","Subject","PriorityIconSmall"),true,220,false,3,9,60);
			?>

				<div class="ibox float-e-margins" >
					<div class="ibox-title">
						<h3>Ticket ownership</h3>
					</div>
			               <div class="ibox-content" >
                         
                                <div class="flot-chart-pie-content" style="width:300px;height:243px;" id="flot-pie-chart"></div>
                         
                        </div>
				</div>
            </div>
     </div>
</div>
<script>

var chart = new Chartist.Bar('#ct-chart3', {
 labels: [ <?php print_r ($_categories);?>],
 series: [{
    name: 'Due',
    data: [<?php print_r ($_due);?>]
  } , {
    name: 'NonDue',
    data: [<?php print_r ($_nondue);?>]
  }]
}, {
  fullWidth: true,
  stackBars: true,
     axisY: {onlyInteger: true,offset: 20}
});
var seriesIndex = -1;
chart.on('created', function() {
  // reset series counter
  seriesIndex = -1;
});

chart.on('draw', function(context) {
  if(context.type === 'bar') {

    if(context.index === 0) 
	{
      seriesIndex++;
    }
    
    var seriesName = chart.data.series[seriesIndex].name;
    
    context.element.root().elem('text', {
      x: context.x1,
      y: context.y2 + 12
    }, 'ct-bar-label').text(context.value.y);
	  context.element.attr({style: 'stroke-width: 80px'});
  }
});   

$(function() {
    var data = [
        <?php
		$_staffList =$db->fetch_array("SELECT dbwb_staffid as staffid FROM ".KSQL_TPRFX."dbwb_staffselect WHERE dbwb_staffselected = 1 ORDER BY dbwb_staffid");
        $colorIndex = 0;
        foreach($_staffList as $staff)
        {
             $result =  $db->fetch_array("SELECT ownerstaffname as Staff, COUNT(".KSQL_TPRFX."tickets.ticketmaskid) AS 'Tickets' FROM ".KSQL_TPRFX."tickets RIGHT JOIN ".KSQL_TPRFX."ticketstatus ON ".KSQL_TPRFX."tickets.ticketstatusid = ".KSQL_TPRFX."ticketstatus.ticketstatusid RIGHT JOIN ".KSQL_TPRFX."departments ON ".KSQL_TPRFX."departments.departmentid = ".KSQL_TPRFX."tickets.departmentid WHERE ".KSQL_TPRFX."ticketstatus.title <> 'Closed' AND ".KSQL_TPRFX."tickets.ownerstaffid =". $staff['staffid']."  GROUP BY ownerstaffname");
                $i =1;
                    foreach($result as $stat)
                    {
                        if($i>1)echo","; 
                        echo"{label: \"".$stat["Staff"]." (".$stat["Tickets"].")\",data: ".$stat["Tickets"].",color: \"#".getColorForBigScreen($colorIndex)."\"},";
                        $i++;
                    }
        $colorIndex++;
        }
        ?>];

    var plotObj = $.plot($("#flot-pie-chart"), data, {
        series: {
            pie: {
                show: true
            }
        },
        grid: {
            hoverable: true
        },
		legend:{ margin:[-100,0]},
        tooltip: true,
        tooltipOpts: {
            content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
            shifts: {
                x: 20,
                y: 0
            },
   
        }
    });
});
</script>
</body>
</html>