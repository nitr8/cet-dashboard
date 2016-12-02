<?php 
function getColorsForCharts()
{
//we are using 2 types of charts - for pie chars and graph colors are defined here,
// for chartist its in chartist.min.css - class name  ct-series-a, ct-series-b ...etc
//
// see this for more http://flatuicolors.com
//
//#2ecc71 - emerald
//#d35400 - punkin 

return "colors: [
	/* #3498db - peter river - ArchiveShuttle */
	\"#3498db\",
	/* #2980b9 - belize hole - AS .cloud */
	\"#2980b9\",
	/* MS .cloud & FD ??? FIX */
	\"#d35400\",
	/* #16a085 - green sea  - FlightDeck */
	\"#16a085\",
	/* #f1c40f - sun flower - MS .cloud - graph */
	\"#f1c40f\",
	/* #2c3e50  - midnight blue - tools */
	\"#2c3e50\",
	/* #c0392b - pomegranate - others */
	\"#c0392b\",
	/* #e67e22 - carrot - MailboxShuttle */
	\"#e67e22\",
	/* #8e44ad - wisteria - ADAM */
	\"#8e44ad\",
	/* WTF - PINK */
	\"#FF1493\",
	/* WTF - PINK */
	\"#FF1493\"
	],";
}

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

	$retval = mysql_query("SELECT * FROM ".MYSQL_DB.".Report where reportType = '".$reportTypeId."' order by weekNumber", $conn );
	while ($row = mysql_fetch_array($retval))
	{
		$_reports[] = $row;
		$_selectedReportId  = $row['idReport'];
		$selectedWeekNumber = $row['weekNumber'];
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
							$_html = '
							<table cellpadding="2" cellspacing="1" border="0" style="width: 100%">
							<tr>
								<td style="width: 50%; border-left: none;" class="title">Product</td>
								<td style=" padding-left: 10px;" class="title">Total</td>
							</tr>';
							
							$_noclass = $_count - 1;

							for($i=0; $i<$_count; $i++){
							 
								if(($i%2) == 0){
									$_class = 'odd';
								}else{
									$_class = 'even';
								}
								
								 $value= $_result[$i]['value'];
									$_html .= '
									<tr>
										<td style="border-left: none; border-bottom: none;" class="'.$_class.'">'.$_result[$i]['propertyName'].'</td>
										<td style="padding-left: 10px; border-bottom: none; text-align:center; " class="'.$_class.'">'.$value.'</td>
									</tr>
									';
							}

							$_html .= '</table>';
							if($_count==0)
					$_html ="No records found !";

							echo $_html;
							unset($_html);
							unset($_noclass);
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
<?php if($_count>0){ 


?>
<script>
	var chart =  new Chartist.Bar('#flot-bar-product-count<?php echo $reportTypeId?>', 
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
					top: 150,
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
				echo "[".$stat["weekNumber"].",".$stat["value"]."]";
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
				grid: {
					color: "#999999",
					hoverable: true,
					clickable: true,
					tickColor: "#D4D4D4",
					borderWidth:0,
					hoverable: true,
					margin: {
						top: 0,
						left: 150,
						bottom: 0,
						right: 0
					},
					
				},
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
	} }
function generateTableReport($reportTypeId,$displayStatus = true,$displayOrganization = true)
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
	$_count = count($_result);
	echo ("<div class=\"row\"><div class=\"col-lg-12 ibox-title\"><h3>". $reportTypeName."<span style=\"color:silver;font-size:12px;\"> (".$selectedWeekNumber."|".$selectedYearNumber.")</span></h3>");
	$_html = '
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">';
	if ($_count>0)
	{
		$_html.=	'	
        <table cellpadding="2" cellspacing="1" border="0" style="width: 100%">
    	<tr>
        	<td style=" border-left: none;" class="title">Id</td>
			<td style=" border-left: none;" class="title">Owner</td>
			<td style=" border-left: none;" class="title">Opened</td>
			<td style=" border-left: none;" class="title">Case</td>';
			if ($displayOrganization) 
				$_html.='<td style=" border-left: none;" class="title">Organization</td>';			
		$_html .='
			<td style=" border-left: none;" class="title">First Reponse Time</td>
			<td style=" border-left: none;" class="title">Average Response Time</td>
			<td style=" border-left: none;" class="title">Total replies</td>
			<td style=" border-left: none;" class="title">Priority</td>';

			if ($displayStatus) 
				$_html.='<td style=" border-left: none;" class="title">Status</td>';

							
        $_html.='</tr>';
        
        $_noclass = $_count - 1;

        for($i=0; $i<$_count; $i++)
		{

            if(($i%2) == 0)
			{
                $_class = 'odd';
            }else
			{
                $_class = 'even';
            }

				//2016 28th September 09:12:08
				$parsedTime = DateTime::createFromFormat("Y d???F H:i:s" , $_result[$i]['stringValue2']);
				$openedDateTime = $parsedTime->format("jS F Y");
		
                $_html .= '
                <tr>
                	<td style="border-left: none; border-bottom: none;text-align:center;" class="'.$_class.'">#<b>'.$_result[$i]['intValue1'].'</b></td>
					<td style="border-left: none; border-bottom: none; padding-left:20px;" class="'.$_class.'">'.$_result[$i]['stringValue1'].'</td>
					<td style="border-left: none; border-bottom: none;" class="'.$_class.'">'.$openedDateTime.'</td>
					<td style="border-left: none; border-bottom: none;" class="'.$_class.'">'.$_result[$i]['stringValue3'].'</td>';
					if ($displayOrganization) 
						$_html.='<td style="border-right:none; border-bottom: none;text-align:center;padding-left:10px;padding-right:10px;" class="'.$_class.'">'.($_result[$i]['stringValue6']==""?"N/A":$_result[$i]['stringValue6']).'</td>';
							
					$_html.='<td style="border-left: none; border-bottom: none;text-align:center;" class="'.$_class.'">'.secondsToTime($_result[$i]['intValue2'],$showUnits=true).'</td>
					<td style="border-left: none; border-bottom: none;text-align:center;" class="'.$_class.'">'.secondsToTime($_result[$i]['intValue3'],$showUnits=true).'</td>
					<td style="border-left: none; border-bottom: none;text-align:center;" class="'.$_class.'">'.$_result[$i]['intValue4'].'</td>
					<td style="border-left: none; border-bottom: none;text-align:center;padding-left:10px;padding-right:10px;'.getColorByPriority($_result[$i]['stringValue5']).'" class="'.$_class.'">'.($_result[$i]['stringValue5']==""?"N/A":$_result[$i]['stringValue5']).'</td>';
					if ($displayStatus) 
						$_html.='<td style="border-right:none; border-bottom: none;text-align:center;padding-left:10px;padding-right:10px;" class="'.$_class.'">'.$_result[$i]['stringValue4'].'</td>';

               $_html .= '
			   </tr>';
        }
	
        $_html .= '</table></div>'.$reportTypeDecription;
	}
	else
	{
		$_html .= "</div><div class=\"col-lg-12\" style=\"text-align:center;\"><img src=\"vendor/cet/img/smiley.png\" /></div>".$reportTypeDecription;
	}
	$_html.= '		</div>   </div>
		</div>
</div>';	
        echo $_html;
        unset($_html);
        unset($_noclass);

}
?>