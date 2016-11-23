<div class="wrapper wrapper-content">
<?php
function generateReport ($reportType)
{
$reportTypeId=$reportType;
$i = 0;
$_count = 0;
$_result = array();
$_reports = array();
$_selectedReportId="";
$conn = @mysql_connect(MYSQL_SERVER,MYSQL_USER,MYSQL_PASS);
mysql_select_db(MYSQL_DB);

$retval = mysql_query( "SELECT * FROM ".MYSQL_DB.".Report where reportType = '".$reportTypeId."' order by weekNumber", $conn );
while ($row = mysql_fetch_array($retval))
{
	$_reports[] = $row;
	$_selectedReportId  = $row['idReport'];
}
	
$sql = "SELECT * from ".MYSQL_DB.".ReportType where idReportType = ".$reportTypeId;// Create connection
$retval = mysql_query( $sql, $conn );
while ($row = mysql_fetch_array($retval))
{
	$reportTypeName = $row['ReportTypeName'];
}

$sql = "SELECT * from ".MYSQL_DB.".ReportData where idReport = ".$_selectedReportId; // Create connection
$retval = mysql_query( $sql, $conn );
while ($row = mysql_fetch_array($retval))
{
	$_result[] = $row;
}

$_count = count($_result);

$statisticsArray = array();
$productSQL = mysql_query( "Select distinct propertyname as product from ".MYSQL_DB.".Report r  left join ".MYSQL_DB.".ReportData rd on r.idReport= rd.IdReport  where r.reportType = ".$reportTypeId, $conn );
while ($productSQLrow = mysql_fetch_array($productSQL))
{
	$statistics = array();
	$statsSQL = mysql_query( "SELECT * from ".MYSQL_DB.".Report r  left join ReportData rd on r.idReport= rd.IdReport  where r.reportType = ".$reportTypeId." and propertyName = '".$productSQLrow['product']."' order by weeknumber", $conn );
	while ($row = mysql_fetch_array($statsSQL))
	{
		array_push($statistics,$row);
	}
	array_push($statisticsArray,$statistics);
}

?>

    <div class="row">
        <div class="col-lg-12 ibox-title">
            <h2><?php echo $reportTypeName;?></h2>
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
                    <div class="ibox float-e-margins">
                        <div class="ibox-content" >
                         <div class="flot-chart-content" id="flot-bar-product-count<?php echo $reportType?>"></div>
                        </div>
                    </div>
            </div>
			  <div class="col-lg-2" <?php if($_count==0) echo "style =\"visibility: hidden;\"";  ?>>
                    <div class="ibox float-e-margins">

                    <div class="ibox-content">
                            <div class="flot-chart">
                                <div class="flot-chart-pie-content" id="flot-pie-chart<?php echo $reportType?>"></div>
                            </div>
                        </div>
                    </div>
               </div>			
		</div>
	</div>
	<div class="row">

			<div class="ibox-content">
				<div class="flot-chart">
					<div class="flot-chart-content" id="flot-line-chart-multi<?php echo $reportType?>"></div>
				</div>
			</div>
  
	</div>

<script>
var chart =  new Chartist.Bar('#flot-bar-product-count<?php echo $reportType?>', 
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

    var plotObj = $.plot($("#flot-pie-chart<?php echo $reportType?>"), data, {
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
?>


function doPlot(position) {
        $.plot($("#flot-line-chart-multi<?php echo $reportType?>"), [
		
		<?php 
		$j=1;
		for ($statsindex=0;$statsindex < count($statisticsArray);$statsindex++)
		{
			if($j>1)
			echo ", \n";
			echo "{";
			echo " data: statistics".$statsindex.",";
			echo " label: \"".$statisticsArray[$statsindex][0]["propertyName"]."\"";
			//echo var_dump ($statisticsArray[$statsindex]);
			echo "}";
			$j++;
		}
		?>
		], 
		{	
			series: {
				lines: { show: true },
				points: { show: true }
			},	

            yaxes: [{
                min: 0
            }, {
                alignTicksWithAxis: position == "right" ? 1 : null,
                position: position,
            }],
            legend: {
                position: 'nw'
            },
            colors: ["#1ab394","#444444"],
            grid: {
                color: "#999999",
                hoverable: true,
                clickable: true,
                tickColor: "#D4D4D4",
                borderWidth:0,
                hoverable: true 
            },
            tooltip: true,
            tooltipOpts: {
                content: "%s for %x was %y",
                 onHover: function(flotItem, $tooltipEl) {
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
<?php }
	
generateReport(TICKETS_PER_PRODUCT);
generateReport(NEW_ISSUES_PER_PRODUCT);
generateReport(MANAGED_MIGRATIONS);
generateReport(QFE_FIXES_PER_PRODUCT);
?></div>