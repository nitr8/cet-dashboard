<?php
$i = 0;
$_count = 0;
$_result = array();
$_reports = array();
$_selectedReportId = 0;
$weekNumber = 0;
$propertyName1="";
$propertyName2="";
$propertyName3="";

$conn = @mysql_connect(MYSQL_SERVER,MYSQL_USER,MYSQL_PASS);
mysql_select_db(MYSQL_DB);

$reportTypeId=$_GET['reportTypeID'];
$retval = mysql_query( "SELECT * FROM ".MYSQL_DB.".Report where reportType = '".$reportTypeId."' order by yearNumber, weekNumber", $conn );
while ($row = mysql_fetch_array($retval))
{
	//if ($_selectedReportId  == 0)
		$_selectedReportId  = $row['idReport'];
		
	if($weekNumber == 0)	
		$weekNumber = $row['weekNumber'];
		
		$_reports[] = $row;
}
if(isset($_GET['selectedReportId']))
	$_selectedReportId = $_GET['selectedReportId'];
	
if(isset($_GET['propertyName1']))
	$propertyName1 = $_GET['propertyName1'];	

if(isset($_GET['propertyName2']))
	$propertyName2 = $_GET['propertyName2'];
	
if(isset($_GET['propertyName3']))
	$propertyName3 = $_GET['propertyName3'];	
	
$sql = "SELECT * from ".MYSQL_DB.".ReportType where idReportType = ".$reportTypeId;// Create connection
$retval = mysql_query( $sql, $conn );
while ($row = mysql_fetch_array($retval))
{
	$reportTypeName = $row['ReportTypeName'];
	$reportTypeDecription = $row['ReportDescription'];
}

switch ($reportTypeId)
{
case TICKETS_PER_PRODUCT:
case NEW_ISSUES_PER_PRODUCT:
case MANAGED_MIGRATIONS:
case QFE_FIXES_PER_PRODUCT:
case TOP_TEN_TIME_TAKERS:
	$sql = "SELECT * from ".MYSQL_DB.".ReportData where idReport = ".$_selectedReportId; // Create connection
	break;
case AGED_CASES:
case QFE_CLOSED:
case CLOSED_CASES:
case URGENT_CASES:
case SLA_BROKEN:
	$sql = "SELECT * from ".MYSQL_DB.".ReportDataForTicket where idReport = ".$_selectedReportId; // Create connection
	break;
	
}
$retval = mysql_query( $sql, $conn );
while ($row = mysql_fetch_array($retval))
{
	$_result[] = $row;
}

$SQLlistOfProps = "SELECT DISTINCT PropertyName from ".MYSQL_DB.".Report r  left join ReportData rd on r.idReport= rd.IdReport  where r.reportType = ".$reportTypeId;
$SQLlistOfPropsRetVal = mysql_query( $SQLlistOfProps, $conn );
while ($row = mysql_fetch_array($SQLlistOfPropsRetVal))
{
	$listOfProperties[] = $row;
	
	if(($propertyName1<>"") and  ($propertyName2<>"") and  ($propertyName3==""))	
		$propertyName3=$row["PropertyName"];	
	
	if($propertyName1!="" and  $propertyName2=="")	
		$propertyName2=$row["PropertyName"];

	if($propertyName1=="")	
		$propertyName1=$row["PropertyName"];
}
?>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12 ibox-title">
            <h2> <?php echo $reportTypeName; ?> </h2>
			
			<div class="row">
				<div class="col-sm-4">
					<select name="week" class="form-control m-b" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
					<?php
					   for($i=0; $i<count($_reports); $i++)
					   {
							echo "<option value =\"?page=managment_reports&reportTypeID=".$reportTypeId."&selectedReportId=".$_reports[$i]['idReport']."&propertyName1=".$propertyName1."&propertyName2=".$propertyName2."&propertyName3=".$propertyName3."\"";
							
							if($_reports[$i]['idReport'] == $_selectedReportId) echo " SELECTED";
							echo ">";
							echo"Week number : ".$_reports[$i]['weekNumber']." (".date('d/m/Y',strtotime($_reports[$i]['dateFrom']))." - ".date('d/m/Y',strtotime($_reports[$i]['dateTo'])).")</option>";
						}
					?>
					</select>
			</div>
			</div>
			
<?php

if(
	$reportTypeId == TICKETS_PER_PRODUCT || 
	$reportTypeId == NEW_ISSUES_PER_PRODUCT || 
	$reportTypeId == MANAGED_MIGRATIONS || 
	$reportTypeId == QFE_FIXES_PER_PRODUCT || 
	$reportTypeId == TOP_TEN_TIME_TAKERS)			
{
	$_count = count($_result);
?>
			<div class="col-lg-4">
				<div class="ibox float-e-margins">
					<div class="ibox-content">
<?php 
		echo generateTableForProductList($_result,$reportTypeId);

?>
                        </div>
                    </div>
               </div>
			<div class="col-lg-6" <?php if($_count==0) echo "style =\"visibility: hidden;\"";  ?>>
                    <div class="ibox float-e-margins">
                        <div class="ibox-content" >
                         <div class="flot-chart-content" id="flot-bar-product-count"></div>
                        </div>
                    </div>
            </div>
			  <div class="col-lg-2" <?php if($_count==0) echo "style =\"visibility: hidden;\"";  ?>>
                    <div class="ibox float-e-margins">

                    <div class="ibox-content">
                            <div class="flot-chart">
                                <div class="flot-chart-pie-content" id="flot-pie-chart"></div>
                            </div>
                        </div>
                    </div>
               </div>
        </div>
	</div>
	<div class="row">
	  <div class="col-lg-12 ibox-title">
		<h4>
			<span style="color:silver;font-size:12px;">Overview</span>
		</h4>
		<div class="col-lg-4">
                <div class="ibox-title">
                     <select name="listofProps" class="form-control m-b" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
				<?php
				   for($i=0; $i<count($listOfProperties); $i++)
				   {
						echo "<option value =\"?page=managment_reports&reportTypeID=".$reportTypeId."&selectedReportId=".$_selectedReportId."&propertyName1=".$listOfProperties[$i]['PropertyName']."&propertyName2=".$propertyName2."&propertyName3=".$propertyName3."\"";
						if($listOfProperties[$i]['PropertyName'] == $propertyName1) echo " SELECTED";
						echo ">";
						echo $listOfProperties[$i]['PropertyName']."</option>";
					}
				?>
				</select>
			</div>
        </div>
		<div class="col-lg-4">
                <div class="ibox-title">
                     <select name="listofProps" class="form-control m-b" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
				<?php
				   for($i=0; $i<count($listOfProperties); $i++)
				   {
						echo "<option value =\"?page=managment_reports&reportTypeID=".$reportTypeId."&selectedReportId=".$_selectedReportId."&propertyName1=".$propertyName1."&propertyName2=".$listOfProperties[$i]['PropertyName']."&propertyName3=".$propertyName3."\"";
						if($listOfProperties[$i]['PropertyName'] == $propertyName2) echo " SELECTED";
						echo ">";
						echo $listOfProperties[$i]['PropertyName']."</option>";
					}
				?>
				</select>
			</div>
        </div>	
		<div class="col-lg-4">
                <div class="ibox-title">
                     <select name="listofProps" class="form-control m-b" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
				<?php
				   for($i=0; $i<count($listOfProperties); $i++)
				   {
						echo "<option value =\"?page=managment_reports&reportTypeID=".$reportTypeId."&selectedReportId=".$_selectedReportId."&propertyName1=".$propertyName1."&propertyName3=".$listOfProperties[$i]['PropertyName']."&propertyName2=".$propertyName2."\"";
						if($listOfProperties[$i]['PropertyName'] == $propertyName3) echo " SELECTED";
						echo ">";
						echo $listOfProperties[$i]['PropertyName']."</option>";
					}
				?>
				</select>
			</div>
        </div>			
		<div class="ibox-content"><?php if($_count>0){?>
				<div class="flot-chart">
					<div class="flot-chart-content" id="flot-line-chart-multi"></div>
				</div>
				<?php }echo $reportTypeDecription;?>
			</div>
        </div>
<script>
var chart =  new Chartist.Bar('#flot-bar-product-count', 
{
  labels: [<?php
            $i =1;
            foreach($_result as $record)
            {
            if($i>1)echo","; 
            echo "'".$record["propertyName"]."'";
            $i++;
            }
        ?>],
  series:[<?php
            $i =1;
            foreach($_result as $record)
            {
            if($i>1)echo","; 
           echo $record["value"];
            $i++;
            }
        ?>]
},
{
        distributeSeries: true,
        axisY: {onlyInteger: true,offset: 20}
});

$(function() {
    var data = [
        <?php
        $colorIndex = 0;
                    $i =1;
                 foreach($_result as $record)
                    {
                        if($i>1)echo""; 
                        echo"{label: \"".$record["propertyName"]." (".$record["value"].")\",data: ".$record["value"]."},";
                        $i++;
						$colorIndex++;
                    }
        
        
        ?>];

    var plotObj = $.plot($("#flot-pie-chart"), data, {
        series: {
            pie: {
                show: true
            }
        },
		<?php echo getColorsForCharts();?>
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

$statsSQL = mysql_query( "SELECT * from ".MYSQL_DB.".Report r  left join ReportData rd on r.idReport= rd.IdReport  where r.reportType = ".$reportTypeId." and propertyName = '".$propertyName1."' order by weeknumber", $conn );
while ($row = mysql_fetch_array($statsSQL))
{
	$stats1[] = $row;
}

$statsSQL = mysql_query( "SELECT * from ".MYSQL_DB.".Report r  left join ReportData rd on r.idReport= rd.IdReport  where r.reportType = ".$reportTypeId." and propertyName = '".$propertyName2."' order by weeknumber", $conn );
while ($row = mysql_fetch_array($statsSQL))
{
	$stats2[] = $row;
}
$statsSQL = mysql_query( "SELECT * from ".MYSQL_DB.".Report r  left join ReportData rd on r.idReport= rd.IdReport  where r.reportType = ".$reportTypeId." and propertyName = '".$propertyName3."' order by weeknumber", $conn );
while ($row = mysql_fetch_array($statsSQL))
{
	$stats3[] = $row;
}
?>

$(function() {
    var statisticsLeftSide = [
    <?php
            $i =1;
            foreach($stats1 as $stat)
            {
            if($i>1)echo","; 
            echo "[".recalculateWeekFromWeekAndYear($stat["weekNumber"],$stat["yearNumber"]).",".$stat["value"]."]";
            $i++;
            }
        ?>];

	var statisticsRightSide = [
    <?php
            $i =1;
            foreach($stats2 as $stat)
            {
            if($i>1)echo","; 
               echo "[".recalculateWeekFromWeekAndYear($stat["weekNumber"],$stat["yearNumber"]).",".$stat["value"]."]";
            $i++;
            }
        ?>];
			var statisticsmiddle = [
    <?php
            $i =1;
            foreach($stats3 as $stat)
            {
            if($i>1)echo","; 
               echo "[".recalculateWeekFromWeekAndYear($stat["weekNumber"],$stat["yearNumber"]).",".$stat["value"]."]";
            $i++;
            }
        ?>];

statisticsRightSide = addzeroes(statisticsmiddle,statisticsRightSide).sort(sortFunction);		
statisticsLeftSide = addzeroes(statisticsmiddle,statisticsLeftSide).sort(sortFunction);
statisticsRightSide = addzeroes(statisticsLeftSide,statisticsRightSide).sort(sortFunction);
statisticsLeftSide = addzeroes(statisticsRightSide,statisticsLeftSide).sort(sortFunction);
statisticsmiddle = addzeroes(statisticsRightSide,statisticsmiddle).sort(sortFunction);
statisticsmiddle = addzeroes(statisticsLeftSide,statisticsmiddle).sort(sortFunction);



function doPlot(position) {
        $.plot($("#flot-line-chart-multi"), [{
            data: statisticsLeftSide,
            label: "<?php echo $propertyName1;?>"
        }, {
            data: statisticsRightSide,
            label: "<?php echo $propertyName2;?>",
           
        },
		{
            data: statisticsmiddle,
            label: "<?php echo $propertyName3;?>",
            
        }
		], 
		{	
			series: {
				lines: { show: true },
				points: { show: true }
			},	
		
            
				yaxes: [
				{
					min: 0
				}, 
				
				{
					alignTicksWithAxis: position == "right" ? 1 : null,
					position: position,
				}],
				
				xaxis: 
				{
   					tickFormatter: weekLabelGenerator 
				},
				legend: 
				{
					position: 'nw',
					margin: {
					top: 0,
					left: 0,
					bottom: 0,
					right: 0
				}
				},
				<?php echo getColorsForCharts();?>
				<?php echo getGridSettings();?>
				tooltip: true,
				tooltipOpts: 
				{
					content: "Count for %s in week %x was %y",
					onHover: function(flotItem, $tooltipEl) 
					{
					}
				}

        });
    }

    doPlot("right");

    $("button").click(function() {
        doPlot($(this).text());
    });
});

</script>

<?php 
}
else
if(
	$reportTypeId == AGED_CASES || 
	$reportTypeId == CLOSED_CASES || 
	$reportTypeId == QFE_CLOSED ||
	$reportTypeId == SLA_BROKEN || 
	$reportTypeId == URGENT_CASES)
{
?>
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-content">
					<?php 
					$_html = "";
					if(count($_result) > 0 )
					{
						echo generateTableFromResult($_result, $reportTypeId != QFE_CLOSED, ($reportTypeId != CLOSED_CASES && $reportTypeId != QFE_CLOSED));
					}
					else
					{
						$_html = "<div class=\"col-lg-12\" style=\"text-align:center;\"><img src=\"vendor/cet/img/smiley.png\" /></div>";
					}
					echo $_html;
					unset($_html);
					unset($_noclass);
					?>
                        </div>
                    </div>
               </div>

<?php
}
?>
		</div>
	</div>
</div>