<?php 
/////////////////////////////////////////////
//Bamboo HR stuff 

include "BambooHR/API/API.php";
use \BambooHR\API\BambooAPI as BHR;

$api = new BHR(BAMBOO_COMPANY);
$api->setSecretKey(BAMBOO_SECRET);
$authenticated = $api->login(BAMBOO_SECRET, BAMBOO_LOGIN,BAMBOO_PWD);
$dateFromBamboo = date("Y-m-d");
$dateToBamboo = date("Y-m-d", strtotime("+30 day", time()));

$parameter=array("status" => "approved","start"=>date("Y-m-d"),"end"=>$dateToBamboo);
$response = $api->getTimeOffRequestsArr($parameter);
/////////////////////////////////////////////


$_currentdate = datetoday();
$_departmentid = 3;
$_categories = '';

$_due = '';
$_nondue = '';

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
        for($i = 0; $i < $_count; $i++){
        if($i == ($_count - 1)){
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

?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
             <div class="dashboardcounter" style="background-color:#1c84c6">
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
            <div class="dashboardcounter" style="background-color:DarkKhaki">
                 <div class="dashboardcounterparent">
                     <?php $ticketCount = $db->getTicketCountforStatus('Resolved','CET');?>
                     <div class="dashboardcounterheader">Resolved</div>
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
            <div class="dashboardcounter" style="background-color:gold">
                 <div class="dashboardcounterparent">
                     <?php $ticketCount = $db->getTicketCountforStatus('Closed','CET');?>
                     <div class="dashboardcounterheader">Closed</div>
                     <div class="dashboardcounternumber"><?php echo $ticketCount?></div>
                 </div>
            </div>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
                <div class="col-sm-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                        <h5>Ticket Count according to Product Type</h5>
                         <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                         </div>
                            
                        </div>
                        <div class="ibox-content">
                            <div id="ct-chart3" class="ct-perfect-third"></div>
                        </div>
                    </div>
                </div>
     </div>
    <div class="row">
          <div class="col-sm-4">
            <?php                     
	
            $query ="SELECT ticketid, subject FROM ".KSQL_TPRFX."tickets WHERE ticketstatustitle = 'Open' AND departmenttitle='CET' ORDER BY dateline DESC LIMIT 5";
			generateBox($db,"New Tickets",$query, array("ticketid","subject"),array("ID","Subject"),true,0,true,5,5, 60) ;
            $_startdate = time();
            $_enddate = time() + 604800; // 7 days
            $_startdate = date('d/m/Y', $_startdate);
            $_enddate = date('d/m/Y', $_enddate);
            ?>
			<div class="ibox float-e-margins" >
				<div class="ibox-title">
					<h5>Approved time off from <?php echo (date("jS F", strtotime($dateFromBamboo))." to ".date("jS F", strtotime($dateToBamboo) ));?></h5>
				
				</div>
				<div class="ibox-content">
                <?php
					echo generateDayOffBoxFromResponse($response);
				?>
                  </div>
			</div></div>
            <div class="col-sm-4">
            <?php
               $query ="SELECT ticketid, subject FROM ".KSQL_TPRFX."tickets WHERE ownerstaffid = 0 AND ticketstatustitle = 'Open' AND departmentid = $_departmentid ORDER BY dateline DESC LIMIT 5";
			   generateBox($db,"Unassigned Tickets",$query, array("ticketid","subject"),array("ID","Subject"),true) ;
               $query ="SELECT ticketid, subject, ownerstaffname FROM " . KSQL_TPRFX . "tickets WHERE ((duetime <= '" . datetoday() . "' AND duetime != '0') OR (resolutionduedateline <= '" . datetoday() . "' AND resolutionduedateline != '0')) AND isescalatedvolatile = '0' AND isresolved = '0' AND ticketstatustitle = 'Open'  AND departmentid = $_departmentid ORDER BY `dateline` DESC LIMIT 5";
			   generateBox($db,"Overdue Tickets",$query, array("ticketid","ownerstaffname","subject"),array("ID","Owner","Subject"),true,0,true,5,5, 60) ;
            ?>
            </div>
            <div class="col-sm-4">
            <?php
               $query ="SELECT ticketid, subject, ownerstaffname FROM ".KSQL_TPRFX."tickets WHERE ticketstatustitle = 'Closed' AND departmentid = $_departmentid ORDER BY dateline DESC LIMIT 10";
		       generateBox($db,"Last 10 completed tickets",$query, array("ticketid","ownerstaffname","subject"),array("ID","Owner","Subject"),false,0,false,5,10,60) ;
            ?>
            </div>
			
     </div>
	 <div class="row">
	       <div class="col-sm-12">
            <?php
				$query ="SELECT  kbarticleid, subject, from_unixtime(editeddateline, '%D %M %Y') as edited,from_unixtime(dateline, '%D %M %Y') as created,views FROM ".KSQL_TPRFX."kbarticles where editeddateline< UNIX_TIMESTAMP(DATE_SUB(NOW(),INTERVAL 1 YEAR)) order by editeddateline desc";
				generateBox($db,"KB articles older than year",$query, array("kbarticleid","subject", "edited","created","views"),array("ID","Subject","Modified","Created","Views"),true,0,false,5,10) ;
		       ?>
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
</script>