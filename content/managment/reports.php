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
$retval = mysql_query( "SELECT * FROM ".MYSQL_DB.".Report where reportType = '".$reportTypeId."' order by weekNumber", $conn );
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
		if($_count>0)
		{
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
			 if($reportTypeId == TOP_TEN_TIME_TAKERS)
			 $value= secondsToTime($_result[$i]['value']);
                $_html .= '
                <tr>
                	<td style="border-left: none; border-bottom: none;" class="'.$_class.'">'.$_result[$i]['propertyName'].'</td>
                    <td style="padding-left: 10px; border-bottom: none; text-align:center; " class="'.$_class.'">'.$value.'</td>
                </tr>
                ';
        }

        $_html .= '</table>';
		}
		else
		{
		$_html ="<img src=\"vendor/cet/img/smiley.png\" />";
		}
		

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
	  <h4><span style="color:silver;font-size:12px;">Overview</span></h4>
	  
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
                        echo"{label: \"".$record["propertyName"]." (".$record["value"].")\",data: ".$record["value"].",color: \"#".$colors[$colorIndex]."\"},";
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
            echo "[".$stat["weekNumber"].",".$stat["value"]."]";
            $i++;
            }
        ?>];

	var statisticsRightSide = [
    <?php
            $i =1;
            foreach($stats2 as $stat)
            {
            if($i>1)echo","; 
               echo "[".$stat["weekNumber"].",".$stat["value"]."]";
            $i++;
            }
        ?>];
			var statisticsmiddle = [
    <?php
            $i =1;
            foreach($stats3 as $stat)
            {
            if($i>1)echo","; 
               echo "[".$stat["weekNumber"].",".$stat["value"]."]";
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
		
            
            yaxes: [{
                min: 0
            }, {
                // align if we are to the right
                alignTicksWithAxis: position == "right" ? 1 : null,
                position: position,
               
            }],
            legend: {
                position: 'ne'
            },
            colors: ["#1ab394","#444444"],
            grid: {
                color: "#999999",
                hoverable: true,
                clickable: true,
                tickColor: "#D4D4D4",
                borderWidth:0,
                hoverable: true //IMPORTANT! this is needed for tooltip to work,

            },
            tooltip: true,
            tooltipOpts: {
                content: "%s for %x was %y",
                //xDateFormat: "%Y/%m/%d %H:%M",

                onHover: function(flotItem, $tooltipEl) {
                    // console.log(flotItem, $tooltipEl);
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
   $_count = count($_result);
   if($_count > 0 )
   {
        $_html = '
        <table cellpadding="2" cellspacing="1" border="0" style="width: 100%">
    	<tr>
        	<td style=" border-left: none;" class="title">Id</td>
			<td style=" border-left: none;" class="title">Owner</td>
			<td style=" border-left: none;" class="title">Opened</td>
			<td style=" border-left: none;" class="title">Case</td>
			<td style=" border-left: none;" class="title">First Reponse Time</td>
			<td style=" border-left: none;" class="title">Average Response Time</td>
			<td style=" border-left: none;" class="title">Total replies</td>
			<td style=" border-left: none;" class="title">Priority</td>
			<td style=" border-left: none;" class="title">Status</td>
        </tr>';
     
        $_noclass = $_count - 1;

        for($i=0; $i<$_count; $i++){
         
            if(($i%2) == 0){
                $_class = 'odd';
            }else{
                $_class = 'even';
            }
                $_html .= '
                <tr>
                	<td style="border-left: none; border-bottom: none;text-align:center;" class="'.$_class.'">#<b>'.$_result[$i]['intValue1'].'</b></td>
					<td style="border-left: none; border-bottom: none; padding-left:20px;" class="'.$_class.'">'.$_result[$i]['stringValue1'].'</td>
					<td style="border-left: none; border-bottom: none;" class="'.$_class.'">'.$_result[$i]['stringValue2'].'</td>
					<td style="border-left: none; border-bottom: none;" class="'.$_class.'">'.$_result[$i]['stringValue3'].'</td>
					<td style="border-left: none; border-bottom: none;text-align:center;" class="'.$_class.'">'.secondsToTime($_result[$i]['intValue2']).'</td>
					<td style="border-left: none; border-bottom: none;text-align:center;" class="'.$_class.'">'.secondsToTime($_result[$i]['intValue3']).'</td>
					<td style="border-left: none; border-bottom: none;text-align:center;" class="'.$_class.'">'.$_result[$i]['intValue4'].'</td>
					<td style="border-left: none; border-bottom: none;text-align:center;padding-left:10px;padding-right:10px;'.getColorByPriority($_result[$i]['stringValue5']).'" class="'.$_class.'">'.($_result[$i]['stringValue5']==""?"N/A":$_result[$i]['stringValue5']).'</td>
					<td style="border-left: none; border-bottom: none;text-align:center;padding-left:10px;padding-right:10px;" class="'.$_class.'">'.$_result[$i]['stringValue4'].'</td>
                    
                </tr>
                ';
        }
	
        $_html .= '</table>';
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