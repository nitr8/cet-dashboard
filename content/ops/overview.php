<form action="index.php" method="get">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-8">
		<?php 
		
		$rng = 0;
		$frmDateFrom="";
		$frmDateTo="";
		$dateFrom="";
		$dateTo="";
		
		if (isset($_GET['dateRange']))
			$rng= $_GET['dateRange'];

		$ticketId = isset($_GET['ticketid']) ? $_GET['ticketid'] : 0;					
		
		if (isset($_GET['dateFrom']))
		  $frmDateFrom = $_GET['dateFrom'];
		if (isset($_GET['dateTo']))
		  $frmDateTo = $_GET['dateTo'];
		  
		$customerCount = 0;
		
		$productCount = $db->fetch_array(getQueryProductCount());
		
		$dailycheckList = $db->fetch_array("SELECT ticketid,subject FROM ".KSQL_PRFX.".swtickets where ticketstatustitle = 'Daily Checks' order by subject");
	
		if($ticketId==0)
			$ticketId = $dailycheckList[0]['ticketid'];
		$productSpent = $db->fetch_array("SELECT UNIX_TIMESTAMP(Date (FROM_UNIXTIME(dateline))) as dat ,sum(timespent) as ts FROM ".KSQL_PRFX.".swtickettimetracks  where ticketid = ".$ticketId."  group by dat");
		$customerTimeSpent = $db->fetch_array(getQueryTimeWorked());
		
		$migrated = $db->query_first( "SELECT count(*) as cnt FROM ".KSQL_PRFX.".swtickets t, ".KSQL_PRFX.".swticketauditlogs al where t.departmenttitle = 'OPS' and t.ticketid=al.ticketid and al.actionmsg='Ticket status changed from: Daily Checks to: Closed'");
		$migratedCustomers = $migrated['cnt'];
		
		foreach ($customerTimeSpent as &$customer)
		{
			if (isset($_GET['dateFrom']) && isset($_GET['dateTo']) && $_GET['dateFrom']!="" && $_GET['dateTo']!="")
			{
				$dateFrom = date_create_from_format('d/m/Y', $_GET['dateFrom'])->setTime(0,0,0)->getTimestamp();
				$dateTo = date_create_from_format('d/m/Y', $_GET['dateTo'])->setTime(23,59,59)->getTimestamp();
			}

			$queryWithFilter = "SELECT sum(timespent) as ts FROM ".KSQL_PRFX.".swtickettimetracks where ticketid=".$customer['ticketid'];
			if ($dateFrom!="")
				$queryWithFilter .=" and dateline > ".$dateFrom;
			if ($dateFrom!="")
				$queryWithFilter .=" and dateline < ".$dateTo; 
			$cst = $db->query_first($queryWithFilter);
			$customer['timeworked'] = $cst['ts']==""?0:$cst['ts'];
		}

		$index=0;
		foreach($productCount as $record)
		{
			$customerCount+= $record["cnt"];  
		?>
               <div class="dashboardcounter" style="background-color:#<?php echo $colors[$index]; ?>">
                   <div class="dashboardcounterparent">
                       <div class="dashboardcounterheader"><?php echo $record["product"];?></div>
                       <div class="dashboardcounternumber"><?php echo $record["cnt"];?></div>
                   </div>
               </div>
		<?php 
			$index++;
		}
		?>
               <div class="dashboardcounter" style="background-color:lightgoldenrodyellow">
                   <div class="dashboardcounterparent">
                       <div class="dashboardcounterheader">Migrated</div>
                       <div class="dashboardcounternumber"><?php echo ($migratedCustomers);?></div>
                   </div>
               </div>
			
			<div class="dashboardcounter" style="background-color:#1c84c6">
                   <div class="dashboardcounterparent">
                       <div class="dashboardcounterheader">Customers</div>
                       <div class="dashboardcounternumber"><?php echo ($customerCount);?></div>
				</div>
			</div>
       </div>

        </div>
	<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
			   <div class="col-lg-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Products <small>(ops/daily checks)</small></h5>
                        </div>
                        <div class="ibox-content" style="height:300px">
                         <div class="flot-chart-content" id="flot-bar-product-count"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Active Migrations Time Spent [HH:MM:SS]  
							<?php  
							if ($dateFrom!="") 
								echo (" - from ".unixtodate($dateFrom));
									if ($dateTo!="") 
								echo (" to ".unixtodate($dateTo));
							?></h5>
                        </div>
                        <div class="ibox-content"  style="height:300px">
                             
                                    <div class="flot-chart-content" id="flot-bar-time-spent"></div>
                                </div>
                        </div>
                    </div>
                </div>
				<div class="row">		   
					<div class="col-sm-6">
					<?php 
						$query ="SELECT ticketid, subject, FROM_UNIXTIME(dateline) as created, timeworked ,FROM_UNIXTIME(lastactivity) as reply from  ".KSQL_TPRFX."tickets where ticketstatustitle = 'Daily Checks' order by subject";
						generateBox($db,"Daily Check tickets",$query, array("ticketid","subject", "created","reply" ,"timeworked"),array("ID","Subject","Created","Last Activity","Time Spent"),true,0,false,5,100) ;
					?>
					</div> 
				<div class="col-sm-6">
					<div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Daily time spent for </small></h5>
							<select name="ticketid" class="form-control m-b">
							<?php 
							foreach($dailycheckList as $t)
							{
							echo ("<option ");
								if ($t['ticketid']==$ticketId) echo "selected";
							echo (" value =".$t['ticketid'].">".$t['subject']."</option>");
							}
							?>
							</select> 
							<div class="row">
								<div class="col-sm-4">
									<select id="dateRange" name="dateRange"  onchange='onChangeSelect()'>
										<option value="0" <?php if($rng==0) echo "selected";?>>Unlimited</option>
										<option value="1" <?php if($rng==1) echo "selected";?>>Today</option>
										<option value="2" <?php if($rng==2) echo "selected";?>>Last 7 days</option>
										<option value="3" <?php if($rng==3) echo "selected";?>>This month</option>
										<option value="4" <?php if($rng==4) echo "selected";?>>This year</option>
										<option value="5" <?php if($rng==5) echo "selected";?>>Custom</option>
									</select>
								</div>				
								<div class="col-sm-6">
										<div class="input-daterange input-group" id="datepicker">
											<input id="dateFrom" class="datepicker" size='11' name="dateFrom" title='DD-MM-YYYY' value="<?php echo($frmDateFrom);?>" /> 
											<input id="dateTo" class='datepicker' size='11' name="dateTo" title='D-MMM-YYYY' value="<?php echo($frmDateTo);?>"/> 
										</div>
										<input type="hidden" name = "page" value = "ops_overview"/>
								</div>
								<div class="col-sm-2">	
										<input type="submit" value="Apply">
								</div>	
							</div>				
						</div>	
						
                        <div class="ibox-content" style="height:300px">
							<div class="flot-chart-content" id="flot-bar-last10-count"></div>
                        </div>
                    </div>
				</div> 
		
			</div>
			<div class="row">		   
					<div class="col-sm-6">
					<?php 
						$query ="select '' as nr, ownerstaffname, count(ownerstaffname) as cnt, coalesce(a.ts,'0') as timespent from ".KSQL_TPRFX."tickets ";
						$query .="left join ";
						$query .="(SELECT swtickettimetracks.workerstaffname as workerstaffname ,sum(timespent) as ts FROM ".KSQL_TPRFX."tickettimetracks  ";
						$query .="left join ".KSQL_TPRFX."tickets on ".KSQL_TPRFX."tickettimetracks.ticketid = ".KSQL_TPRFX."tickets.ticketid ";
						$query .="where ".KSQL_TPRFX."tickettimetracks.dateline > UNIX_TIMESTAMP(adddate(curdate(), INTERVAL 1-DAYOFWEEK(curdate()) DAY)) and ticketstatustitle='Daily Checks'  group by workerstaffname ) a ";
						$query .="on a.workerstaffname = ".KSQL_TPRFX."tickets.ownerstaffname ";
						$query .="where ticketstatustitle='Daily Checks' group by ownerstaffname ";
						generateBox($db,"Time spent on tickets this week",$query, array("nr","ownerstaffname","cnt","timespent",),array("","Worker name","Assigned customers","Time Spent"),true,0,false,5,100) ;
					?>
					</div> 
				
			</div>					
</form>
 <script>

function onChangeSelect()
{

	var e = document.getElementById("dateRange");
	var selected = e.options[e.selectedIndex].value;
	switch (selected)
	{
	case "0":
		document.querySelector('#dateTo').value ="";
		document.querySelector('#dateFrom').value="";
		break;
	case "1":
		var myDate = new Date();
		var dateFrom = new Date(myDate.getTime());
		var dateTo =new Date(myDate.getTime());
		document.querySelector('#dateFrom').value =dateFrom.getDate()+'/'+(dateFrom.getMonth()+1)+'/'+dateFrom.getFullYear();
		document.querySelector('#dateTo').value =dateTo.getDate()+'/'+(dateTo.getMonth()+1)+'/'+dateTo.getFullYear();
		break;
		
	case "2":
		var dateTo = new Date();
		var dateFrom = new Date(dateTo.getTime() - (60*60*24*7*1000));
		document.querySelector('#dateFrom').value =dateFrom.getDate()+'/'+(dateFrom.getMonth()+1)+'/'+dateFrom.getFullYear();
		document.querySelector('#dateTo').value =dateTo.getDate()+'/'+(dateTo.getMonth()+1)+'/'+dateTo.getFullYear();
		break;
	case "3":
		var dateTo = new Date();
		var dateFrom = new Date();
		document.querySelector('#dateFrom').value ='1/'+(dateFrom.getMonth()+1)+'/'+dateFrom.getFullYear();
		document.querySelector('#dateTo').value ='1/'+(dateTo.getMonth()+2)+'/'+dateTo.getFullYear();
		break;
	case  "4":
		var year = new Date().getFullYear();
		document.querySelector('#dateFrom').value ='1/1/'+year;
		document.querySelector('#dateTo').value ='24/12/'+year;
		break;
	case "5" :
		document.querySelector('#dateTo').value ="";
		document.querySelector('#dateFrom').value="";
	break;
	}
}

var chart =  new Chartist.Bar('#flot-bar-product-count', 
{
  labels: [<?php
            $i =1;
            foreach($productCount as $record)
            {
            if($i>1)echo","; 
            echo "'".$record["product"]."'";
            $i++;
            }
        ?>],
  series:[<?php
            $i =1;
            foreach($productCount as $record)
            {
            if($i>1)echo","; 
           echo $record["cnt"];
            $i++;
            }
        ?>]
},
{
        distributeSeries: true,
        axisY: {onlyInteger: true,offset: 20}
});

var $chart = $(chart.container),
    $toolTip = $chart
    .append('<div class="ct-tooltip"></div>')
    .find('.ct-tooltip')
    .hide();

var tooltipSelector = '.ct-point';
if (chart instanceof Chartist.Bar) {
    tooltipSelector = '.ct-bar';
} else if (chart instanceof Chartist.Pie) {
    tooltipSelector = '[class^=ct-slice]';
}

 $chart.on('mouseenter', tooltipSelector, function() {
    $toolTip.html($(this).attr('ct:value')).show();
});

$chart.on('mouseleave', tooltipSelector, function() {
    $toolTip.hide();
});

$chart.on('mousemove', function(event) {
    $toolTip.css({
        left: (event.offsetX || event.originalEvent.layerX) - $toolTip.width() / 2 + 20,
        top: (event.offsetY || event.originalEvent.layerY) - $toolTip.height() +40
    });
});

//////////////////

var chart2 = new Chartist.Bar('#flot-bar-time-spent', {
  labels: [<?php
            $i =1;
            foreach($customerTimeSpent as $record)
            {
             if($i>1)echo","; 
             echo "'".$record["subject"]."'";
             $i++;
            }
        ?>],
  series:[<?php
            $i =1;
            foreach($customerTimeSpent as $record)
            {
              if($i>1)echo","; 
              echo $record["timeworked"];
              $i++;
            }
        ?>]},
    { 
        distributeSeries: true,
           axisY: {
                    labelInterpolationFnc: function(value) 
                    {
                        return toHHMMSS(value);
                    }
                }
    });

var $chart2 = $(chart2.container),
$toolTip2 = $chart2
.append('<div class="ct-tooltip2"></div>')
.find('.ct-tooltip2')
.hide();

var tooltipSelector2 = '.ct-point';
if (chart2 instanceof Chartist.Bar) {
    tooltipSelector2 = '.ct-bar';
}
 $chart2.on('mouseenter', tooltipSelector2, function() {
    $toolTip2.html(toHHMMSS($(this).attr('ct:value'))).show();
});

$chart2.on('mouseleave', tooltipSelector2, function() {
    $toolTip2.hide();
});

$chart2.on('mousemove', function(event2) {
    $toolTip2.css({
        left: (event2.offsetX || event2.originalEvent.layerX) - $toolTip2.width() / 2 + 20,
        top: (event2.offsetY || event2.originalEvent.layerY) - $toolTip2.height() +40
    });
});





function newDataArray(data) {
  var startDay = data[0][0],
    newData = [data[0]];

  for (i = 1; i < data.length; i++) {
    var diff = dateDiff(data[i - 1][0], data[i][0]);
    var startDate = new Date(data[i - 1][0]);
    if (diff > 1) {
      for (j = 0; j < diff - 1; j++) {
        var fillDate = new Date(startDate).setDate(startDate.getDate() + (j + 1));
          newData.push([fillDate, 0]);
      }
    }
    newData.push(data[i]);
  }
  return newData;
}


/* helper function to find date differences*/
function dateDiff(d1, d2) {
  return Math.floor((d2 - d1) / (1000 * 60 * 60 * 24));
}


$(function() {
    var oilprices = [
    <?php
            $i =1;
            foreach($productSpent as $stat)
            {
            if($i>1)echo","; 
            echo "[".$stat["dat"]."000,".$stat["ts"]."000]";
            $i++;
            }
        ?>];

oilprices = newDataArray(oilprices);
   function doPlot(position) {
        $.plot($("#flot-bar-last10-count"), [{
            data: oilprices,
            label: "Time spent"
        }], {	
			series: {
				lines: { show: true },
				points: { show: true }
			},		
            xaxes: [{
                mode: 'time',
                timeformat:"%d.%m"
            }],
            yaxes: [{
                min: 0,
				                mode: 'time',
                timeformat:"%h:%M:%S"
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
                xDateFormat: "%Y/%m/%d",

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