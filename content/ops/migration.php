<div class="wrapper wrapper-content animated fadeInRight">
<?php

function generateModuleTable($customerId , $conn)
{

			$_html = '<table  width="98%" style="margin:4px">';
			$retval = mysql_query( "SELECT * FROM ".MYSQL_DB.".InstalledModules where customerId='".$customerId."'", $conn );
			
			
			$rowCount = mysql_num_rows($retval);
			if($rowCount>0)
			{
		
				$_html .= '<tr style="font-size:8px;">';
				$_html .= '<td >Computer Name</td>';
				$_html .= '<td >Service Name</td>';
				$_html .= '<td >Version</td>';
				$_html .= '<td >Enabled</td>';
				$_html .= '<td >Last SenDate</td>';
				$_html .= '</tr>';
			}
			else{
			
			$_html .= '<tr style="font-size:8px;"><td>No links synced !</td></tr>';
			}
			while ($row = mysql_fetch_array($retval))
			{
				$_html .= '<tr style="border:1px solid silver;"><td>'.$row["ComputerName"].'</td>';
				$_html .= '<td>'.$row["ServiceName"].'</td>';
				$_html .= '<td>'.$row["Version"].'</td>';
				$_html .= '<td><img src="vendor/cet/img/'.(($row["IsEnabled"]=="0")?"cross":"tick").'.png"/></td>';
				
				$_html .= '<td>'.$row["LastSeenDateUTC"].'</td>';
				$_html.='</tr>';
			}
			$_html .= '</table>';		

		
	return $_html;
}?>

<div class="row border-bottom white-bg dashboard-header">
	<div class="col-lg-12">
         <h5><span class="label label-primary"></span>Installed Modules</h5>
		 <div class="col-lg-6 centered">
				<?php echo generateModuleTable( $_GET['CustomerID'],$conn);?>
		</div>
	</div>
</div>
<?php
$allLinks = GetAllLinkInforForCustomerID($conn, $_GET['CustomerID']);
foreach($allLinks as $record)
{
?>
    <div class="row border-bottom white-bg dashboard-header">
		<div class="col-lg-12">
              <h2> <?php echo $record['LinkName'];?>(<?php echo $record['LinkInfoGuid'];?>)</small></h2>
              <div class="col-lg-4">
				 <h5><span class="label label-success">1</span>Basic info </h5>
                 <ul class="list-group clear-list m-t">
                       <li class="list-group-item fist-item"><span class="pull-right"><?php echo $record['Updated'];?></span>Updated</li>
                       <li class="list-group-item"><span class="pull-right"><?php echo $record['CustomerName'];?></span>Customer Name</li>
                       <li class="list-group-item"><span class="pull-right"><?php echo $record['CloudDbName'];?></span>Cloud Directory DB</li>
                       <li class="list-group-item"><span class="pull-right"><?php echo $record['LinkInfoGuid'];?></span>Link Guid</li>
                       <li class="list-group-item"><span class="pull-right"><?php echo $record['LinkName'];?></span>Link Name</li>
                       <li class="list-group-item"><span class="pull-right"><?php echo $record['STGPath'];?></span>Link Path</li>
                   </ul>
              </div>
              <div class="col-lg-4">
                <h5><span class="label label-info">2</span>Staging Area</h5>
                   <ul class="list-group clear-list m-t">
                       <li class="list-group-item fist-item"><span class="pull-right"><?php echo formatBytes($record['LowWaterMark']);?></span>LowWaterMark</li>
                       <li class="list-group-item "><span class="pull-right"><?php echo formatBytes($record['HighWaterMark']);?></span>HighWaterMark</li>
                       <li class="list-group-item "><span class="pull-right"><?php echo formatBytes( $record['FreeDiskSpace']);?></span>FreediskSpace</li>
					    <li class="list-group-item"><span class="pull-right"><?php echo $record['percentUsed'];?> %</span>Percent Used </li>
        </ul>
		</div>
		<div class="col-lg-4">
				 <div>
                  <div class="flot-chart">
                      <div class="flot-chart-pie-content" style="width:150px;height:150px;" id="flot-pie-stg<?php echo $record['LinkInfoId'];?>"></div>
                  </div>
                 </div>
               </div>
			   
			   
	
			   
               <!--div class="col-lg-3">
                <h5><span class="label label-primary">3</span>Import/export stats</h5>
				 <div class="col-lg-6 centered">
				 Last 24 Hours
				 </div>
				 <div class="col-lg-6 centered">
				 Last 7 Days
				 </div>
				 <div class="col-lg-3">
                   <div class="statcounter" style="background-color:<?php echo($record['Last24HExportedSize']<$record['Average24HExport']?"DarkSalmon":"#1AB394"); ?>">
                       <div class="dashboardcounterparent">
							<div class="dashboardcounterheader">Exported</div>
							<div class="statcounternumber"><?php echo formatBytes($record['Last24HExportedSize']);?></div>
							<div class="dashboardcounterfooter">Avg <?php echo formatBytes($record['Average24HExport']);?></div>
						</div>
					</div>
				 </div>
                <div class="col-lg-3">
                   <div class="statcounter" style="background-color:<?php echo($record['Last24HImportedSize']<$record['Average24HImport']?"DarkSalmon":"#1AB394"); ?>">
                       <div class="dashboardcounterparent">
							<div class="dashboardcounterheader">Imported</div>
							<div class="statcounternumber"><?php echo formatBytes($record['Last24HImportedSize']);?></div>
							<div class="dashboardcounterfooter">Avg <?php echo formatBytes($record['Average24HImport']);?></div>
						</div>
					</div>
				 </div>
				  <div class="col-lg-3">
                   <div class="statcounter" style="background-color:<?php echo($record['Last7DExportedSize']<($record['Average24HExport']*7)?"DarkSalmon":"#1AB394"); ?>">
                       <div class="dashboardcounterparent">
							<div class="dashboardcounterheader">Exported</div>
							<div class="statcounternumber"><?php echo formatBytes($record['Last7DExportedSize']);?></div>
							<div class="dashboardcounterfooter">Avg <?php echo formatBytes($record['Average24HExport']*7);?></div>
						</div>
					</div>
				 </div>
                <div class="col-lg-3">
                   <div class="statcounter" style="background-color:<?php echo($record['Last7DImportedSize']<($record['Average24HImport']*7)?"DarkSalmon":"#1AB394"); ?>">
                       <div class="dashboardcounterparent">
							<div class="dashboardcounterheader">Imported</div>
							<div class="statcounternumber"><?php echo formatBytes($record['Last7DImportedSize']);?></div>
							<div class="dashboardcounterfooter">Avg <?php echo formatBytes($record['Average24HImport']*7);?></div>
						</div>
					</div>
				 </div>			
                   <ul class="list-group clear-list m-t">
                     <li class="list-group-item fist-item"><br />&nbsp;</li>
                     <li class="list-group-item fist-item"><span class="pull-right"><?php echo $record['Last24HImportedItemCount'];?></span>Last 24h imported (item count)</li>
                     <li class="list-group-item"><span class="pull-right"><?php echo $record['Last24HExportedItemCount'];?></span>Last 24h exported (item count)</li>
                     <li class="list-group-item"><span class="pull-right"><?php echo $record['Last7DImportedItemCount'];?></span>Last 7days imported (item count)</li>
                     <li class="list-group-item"><span class="pull-right"><?php echo $record['Last7DExportedItemCount'];?></span>Last 7days exported (item count)</li>

                 </ul>
              </div>
               <div class="col-lg-3">
                <h5><span class="label label-default">4</span>Permanent error count for link</h5>
                  <ul class="list-group clear-list m-t">
                 <li class="list-group-item fist-item"><span class="pull-right"><?php echo $record['FailedExported'];?></span>Failed exported</li>
                 <li class="list-group-item"><span class="pull-right"><?php echo $record['Failedimported'];?></span>Failed imported</li>
                 <li class="list-group-item"><span class="pull-right"><?php echo ($record['FailedExported']+ $record['Failedimported']);?></span>Failed Total</li>
                 </ul>
                 <div>
                  <div class="flot-chart">
                      <div class="flot-chart-pie-content" style="width:150px;height:150px;" id="flot-pie-failed<?php echo $record['LinkInfoId'];?>"></div>
                  </div>
                   </div>
              </div-->
     </div>
	
	   <!--div class="row">
           <div class="col-lg-12">
               <div class="ibox float-e-margins">
                   <div class="ibox-title">
                       <h5>Stats last exported 24h (link Mailboxstore)</h5>
                       <div class="ibox-tools">
                           <a class="collapse-link">
                               <i class="fa fa-chevron-up"></i>
                           </a>
                           <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                               <i class="fa fa-wrench"></i>
                           </a>
                           <ul class="dropdown-menu dropdown-user">
                               <li><a href="#">Config option 1</a>
                               </li>
                               <li><a href="#">Config option 2</a>
                               </li>
                           </ul>
                           <a class="close-link">
                               <i class="fa fa-times"></i>
                           </a>
                       </div>
                   </div>
                   <div class="ibox-content">
                       <div class="flot-chart">
                           <div class="flot-chart-content" id="flot-line-chart-multi<?php echo $record['LinkInfoId'];?>"></div>
                       </div>
                   </div>
               </div>
           </div>
	</div -->
</div>
<?php
}

?>
</div>
<script>

<?php
foreach($allLinks as $record)
{
?>       
$(function() {
    var data = [{
        label: "Free",
        data: <?php echo 100-$record['percentUsed'];?>,
        color: "#d3d3d3",
    }, {
        label: "Used",
        data: <?php echo $record['percentUsed'];?>,
        color: "#1ab394",
    }];

    var plotObj = $.plot($("#flot-pie-stg<?php echo $record['LinkInfoId'];?>"), data, {
        series: {
            pie: {
                show: true
            }
        },
        grid: {
            hoverable: true
        },
        tooltip: true,
        tooltipOpts: {
            content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
            shifts: {
                x: 20,
                y: 0
            },
            defaultTheme: false
        }
    });

});
$(function() {
    var data = [{
        label: "Failed Imported",
        data: <?php echo $record['Failedimported'];?>,
        color: "#d3d3d3",
    }, {
        label: "Failed Exported",
        data: <?php echo $record['FailedExported'];?>,
        color: "#1ab394",
    }];

    var plotObj = $.plot($("#flot-pie-failed<?php echo $record['LinkInfoId'];?>"), data, {
        series: {
            pie: {
                show: true
            }
        },
        grid: {
            hoverable: true
        },
        tooltip: true,
        tooltipOpts: {
            content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
            shifts: {
                x: 20,
                y: 0
            },
            defaultTheme: false
        }
    });

});



<?php
}
?>


</script>