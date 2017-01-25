<?php 

$_currentdate = datetoday();
$_departmentid = 6;
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

?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
             <div class="dashboardcounter" style="background-color:#1c84c6">
                 <div class="dashboardcounterparent">
                     <?php $ticketCount = $db->getTicketCountforStatus('Open','QFE');?>
                     <div class="dashboardcounterheader">Open</div>
                     <div class="dashboardcounternumber"><?php echo $ticketCount?></div>
                 </div>
            </div>
            <div class="dashboardcounter" style="background-color:#1AB394">
                 <div class="dashboardcounterparent">
                     <?php $ticketCount = $db->getTicketCountforStatus('In Progress','QFE');?>
                     <div class="dashboardcounterheader">In Progress</div>
                     <div class="dashboardcounternumber"><?php echo $ticketCount?></div>
                 </div>
            </div>
            <div class="dashboardcounter" style="background-color:#79D2C0">
                 <div class="dashboardcounterparent">
                     <?php $ticketCount = $db->getTicketCountforStatus('Pending','QFE');?>
                     <div class="dashboardcounterheader">Pending</div>
                     <div class="dashboardcounternumber"><?php echo $ticketCount?></div>
                 </div>
            </div>
            <div class="dashboardcounter" style="background-color:DarkKhaki">
                 <div class="dashboardcounterparent">
                     <?php $ticketCount = $db->getTicketCountforStatus('In Testing','QFE');?>
                     <div class="dashboardcounterheader">In Testing</div>
                     <div class="dashboardcounternumber"><?php echo $ticketCount?></div>
                 </div>
            </div>
            <div class="dashboardcounter" style="background-color:gold">
                 <div class="dashboardcounterparent">
                     <?php $ticketCount = $db->getTicketCountforStatus('Closed','QFE');?>
                     <div class="dashboardcounterheader">Closed</div>
                     <div class="dashboardcounternumber"><?php echo $ticketCount?></div>
                 </div>
            </div>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
	 <div class="col-sm-12">
               <?php
                $query ="SELECT ticketid, subject, ownerstaffname,prioritytitle,from_unixtime(resolutiondateline,'%d/%m/%Y')  as resDate,tickettypetitle FROM ".KSQL_TPRFX."tickets WHERE ticketstatustitle = 'Closed' AND departmentid = $_departmentid ORDER BY dateline DESC LIMIT 10";
				
			    generateBox($db,"Last 10 completed tickets",$query, array("ticketid","ownerstaffname","subject", "prioritytitle","resDate","tickettypetitle"),array("ID","Owner","Subject","Priority","Resolution Date","Type"),false,0,false,5,10);
               ?>
           </div>
     </div>
	 <div class="row">		   

           <div class="col-sm-6">
           	<?php 
                $query ="SELECT ticketid,prioritytitle, subject FROM ".KSQL_TPRFX."tickets WHERE ticketstatustitle = 'Open' AND departmentid = $_departmentid ORDER BY dateline DESC LIMIT 5";
			    generateBox($db,"Open Tickets",$query, array("ticketid","subject", "prioritytitle"),array("ID","Subject","Priority"),true) ;
                $query ="SELECT ticketid,ownerstaffname,ticketstatustitle,subject FROM ".KSQL_TPRFX."tickets WHERE ownerstaffname <> '' AND ticketstatustitle <> 'Closed' AND departmentid = $_departmentid ORDER BY dateline DESC LIMIT 5";
			    generateBox($db,"Assigned Tickets",$query, array("ticketid","ownerstaffname","subject","ticketstatustitle"),array("ID","Owner","Subject","Status"),true);
               ?>
           </div>
           <div class="col-sm-6">
			    <?php 
                $query ="SELECT ticketid, subject FROM ".KSQL_TPRFX."tickets WHERE ownerstaffid = 0 AND ticketstatustitle = 'Open' AND departmentid = $_departmentid ORDER BY dateline DESC LIMIT 5";
			    generateBox($db,"Unassigned Tickets",$query, array("ticketid","subject"),array("ID","Subject"),true) ;
                $query ="SELECT ticketid, subject, ownerstaffname FROM ".KSQL_TPRFX."tickets WHERE ticketstatustitle = 'In Testing' AND departmentid = $_departmentid ORDER BY dateline DESC LIMIT 10";
			    generateBox($db,"Tickets In testing status",$query, array("ticketid","ownerstaffname","subject"),array("ID","Owner","Subject"),true);
               ?>
           </div>

		</div>

</div>
