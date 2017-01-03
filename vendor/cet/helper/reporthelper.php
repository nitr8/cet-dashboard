<?php 
function generateReportWithCharts($reportTypeId, $limitWeeks = null, $limitLegend = null)
{
	$i = 0;
	$_count = 0;
	$_result = array();
	$_reports = array();
	$_selectedReportId="";
	$selectedWeekNumber = date("W");
	$selectedYearNumber = date("Y");
	
	$limitweekssql = "";
	if($limitWeeks!=null && ((date("W")-$limitWeeks)>0))
	{
		$limitweekssql = " and r.Weeknumber > ". (date("W")-$limitWeeks);
	}
	
	$conn = @mysql_connect(MYSQL_SERVER,MYSQL_USER,MYSQL_PASS);
	mysql_select_db(MYSQL_DB);

	$retval = mysql_query("SELECT * FROM ".MYSQL_DB.".Report where reportType = '".$reportTypeId."' order by yearNumber, weekNumber", $conn );
	while ($row = mysql_fetch_array($retval))
	{
		$_reports[] = $row;
		$_selectedReportId  = $row['idReport'];
		$selectedWeekNumber = $row['weekNumber'];
		$selectedYearNumber = $row['yearNumber'];
		
	}
		
	$sql = "SELECT * from ".MYSQL_DB.".ReportType where idReportType = ".$reportTypeId;
	$retval = mysql_query( $sql, $conn );
	while ($row = mysql_fetch_array($retval))
	{
		$reportTypeName = $row['ReportTypeName'];
		$reportTypeDecription = $row['ReportDescription'];
	}

	$sql = "SELECT * from ".MYSQL_DB.".ReportData where idReport = ".$_selectedReportId; 
	$retval = mysql_query( $sql, $conn );
	if($retval!=null)
	while ($row = mysql_fetch_array($retval))
	{
		$_result[] = $row;
	}

	$_count = count($_result);

	$statisticsArray = array();
	$productSQL = mysql_query( "Select distinct propertyname as product from ".MYSQL_DB.".Report r  left join ".MYSQL_DB.".ReportData rd on r.idReport= rd.IdReport  where r.reportType = ".$reportTypeId.$limitweekssql . ($limitLegend!=null?(" LIMIT ".$limitLegend ): ""), $conn );

	while ($productSQLrow = mysql_fetch_array($productSQL))
	{
		$statistics = array();

		$command = "SELECT * from ".MYSQL_DB.".Report r  left join ReportData rd on r.idReport= rd.IdReport  where r.reportType = ".$reportTypeId.$limitweekssql." and propertyName = '".$productSQLrow['product']."' order by weeknumber";
		$statsSQL = mysql_query($command , $conn );
		
		while ($row = mysql_fetch_array($statsSQL))
		{
			array_push($statistics,$row);
		}
		array_push($statisticsArray,$statistics);
	}

	?>

		<div class="row">
			<div class="col-lg-12 ibox-title">
				<h3><?php echo $reportTypeName."<span style=\"color:silver;font-size:12px;\"> (".$selectedWeekNumber."|".$selectedYearNumber.")</span></h3>";?>
				<div class="col-lg-4">
					<div class="ibox float-e-margins">
						<div class="ibox-content">
						<?php 
						echo generateTableForProductList($_result, $reportTypeId);
						?>
						</div>
					</div>
				</div>	
			   
				<div class="col-lg-6" <?php if($_count==0) echo "style =\"visibility: hidden;\"";  ?>>
					<div class="ibox-content" >
						 <div class="flot-chart-content" id="flot-bar-product-count<?php echo $reportTypeId?>"></div>
					</div>
				</div>
				<div class="col-lg-2" <?php if($_count==0) echo "style =\"visibility: hidden;\"";  ?>>
					<div class="ibox-content">
						<div class="flot-chart">
							<div class="flot-chart-pie-content" style="width:150px;height:150px;" id="flot-pie-chart<?php echo $reportTypeId?>"></div>
						</div>
					</div>
				</div>			
			</div>
		</div>
		<div class="row">
			<div class="ibox-content"><?php if($_count>0){ ?>
				<h4><span style="color:silver;font-size:12px;">Overview</span></h4>
				<div class="flot-chart">
					<div class="flot-chart-content" id="flot-line-chart-multi<?php echo $reportTypeId?>"></div>
				</div>
				<?php }echo $reportTypeDecription;?>
			</div>
		</div>
<?php if($_count>0)
{ 
?>
<script>
	var chart =  new Chartist.Bar('#flot-bar-product-count<?php echo $reportTypeId?>', 
	{
	  labels: [<?php
				$i =1;
				foreach($_result as $record)
				{
				if($i>1)
					echo","; 
				echo "'".$record["propertyName"]."'";
				$i++;
				}
			?>],
	  series:[<?php
				$i =1;
				foreach($_result as $record)
				{
				if($i>1)
					echo","; 
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
							if($i>1)echo","; 
							echo"{label: \"".$record["propertyName"]." (".$record["value"].")\",data: ".$record["value"]."}";
							$i++;
							$colorIndex++;
						}
			
			
			?>];

		var plotObj = $.plot($("#flot-pie-chart<?php echo $reportTypeId?>"), data, {
			series: {
				pie: {
					show: true
				}
			},
			legend: 
				{
					position: 'nw'
					
					
				},
				<?php echo getColorsForCharts();?>
			grid: {
				hoverable: true,
				margin: {
					top: 135,
					left: 0,
					bottom: 0,
					right: 0
				}
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
	$statsindex = 0;
	<?php

	for ($statsindex=0;$statsindex < count($statisticsArray);$statsindex++)
	{

		echo "  var statistics".$statsindex." = [";
				$i =1;
				foreach($statisticsArray[$statsindex] as $stat)
				{
				if($i>1)echo","; 
				echo "[".recalculateWeekFromWeekAndYear($stat["weekNumber"],$stat["yearNumber"]).",".$stat["value"]."]";
				$i++;
				}
		echo "];\n";
	}
	
	//now we need to add zeroes (every array with every array)
	for ($statsindexY=0;$statsindexY < count($statisticsArray);$statsindexY++)
	{
		for ($statsindex=0;$statsindex < count($statisticsArray);$statsindex++)
			echo "statistics".$statsindex." = addzeroes(statistics".$statsindexY.",statistics".$statsindex.").sort(sortFunction);	";
	}
	
	?>
	function doPlot(position) {
			$.plot($("#flot-line-chart-multi<?php echo $reportTypeId?>"), [
			
			<?php 
			$j=1;
			for ($statsindex=0;$statsindex < count($statisticsArray);$statsindex++)
			{
				if($j>1)
				echo ", \n";
				echo "{";
				echo " data: statistics".$statsindex.",\n";
				echo " label: \"".$statisticsArray[$statsindex][0]["propertyName"]."\"\n";
				echo "}";
				$j++;
			}
			?>
			], 
			{	
				series: 
				{
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
}

function generateTableReport($reportTypeId, $displayStatus = true,$displayOrganization = true)
{
	$selectedWeekNumber = date("W");
	$selectedYearNumber = date("Y");
	$_result = array();
	$_reports = array();
	$_selectedReportId = 0;
	
	$conn = @mysql_connect(MYSQL_SERVER,MYSQL_USER,MYSQL_PASS);
	mysql_select_db(MYSQL_DB);

	$retval = mysql_query("SELECT * FROM ".MYSQL_DB.".Report where reportType = '".$reportTypeId."' order by weekNumber", $conn );
	while ($row = mysql_fetch_array($retval))
	{
		$_reports[] = $row;
		$_selectedReportId  = $row['idReport'];
		$selectedWeekNumber = $row['weekNumber'];
		$selectedYearNumber = $row['yearNumber'];
	}
		
	$sql = "SELECT * from ".MYSQL_DB.".ReportType where idReportType = ".$reportTypeId;
	$retval = mysql_query( $sql, $conn );
	while ($row = mysql_fetch_array($retval))
	{
		$reportTypeName = $row['ReportTypeName'];
		$reportTypeDecription = $row['ReportDescription'];
	}
	
	if(count($_reports) > 0)
	{
		$sql = "SELECT * from ".MYSQL_DB.".ReportDataForTicket where idReport = ".$_selectedReportId;
		$retval = mysql_query( $sql, $conn );
		while ($row = mysql_fetch_array($retval))
		{
			$_result[] = $row;
		}
	}

	echo ("<div class=\"row\"><div class=\"col-lg-12 ibox-title\"><h3>". $reportTypeName."<span style=\"color:silver;font-size:12px;\"> (".$selectedWeekNumber."|".$selectedYearNumber.")</span></h3>");
	$_html = '
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">';
	if (count($_result)>0)
	{
		echo generateTableFromResult($_result,$displayOrganization, $displayStatus);
		$_html .= '</div>';
	}
	else
	{
		$_html .= "</div><div class=\"col-lg-12\" style=\"text-align:center;\"><img src=\"vendor/cet/img/smiley.png\" /></div>";
	}
	$_html.= $reportTypeDecription.'</div></div>
		</div>
	</div>';	
    
	echo $_html;
    unset($_html);
}
?>