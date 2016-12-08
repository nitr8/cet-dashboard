  <?php
$_month = getmonth();            
$_year = getyear();
$_lastday = getdays($_month, $_year);
$queryLastSixWeeksNewByProductresult = array();
//$_starttime = createfirstdayunix($_month, $_year);
//$_endtime =createlastdayunix($_lastday, $_month, $_year);

$_starttime = time() - (7 * 24 * 60 * 60);
$_endtime = time();

$_staffList =$db->fetch_array("SELECT dbwb_staffid as staffid FROM ".KSQL_TPRFX."dbwb_staffselect WHERE dbwb_staffselected = 1 ORDER BY dbwb_staffid");
$colorIndex = 0;

$queryLastSixWeeksNewByProductresult = $db->fetch_array($queryLastSixWeeksNewByProduct);

$averageResolveTime=array();
$averageResponseTime=array();
foreach($_staffList as $staff)
{
    $avgResponseTime = 0;
    $avgResolveTime = 0;
    $Staff='';
    $_averages =$db->fetch_array("SELECT ownerstaffname as Staff, ticketid, (SELECT TIMESTAMPDIFF(SECOND, MIN(from_unixtime(dateline)), MAX(from_unixtime(dateline))) / (COUNT(*) - 1 )/60 FROM ".KSQL_TPRFX."ticketposts WHERE ".KSQL_TPRFX."ticketposts.ticketid = ".KSQL_TPRFX."tickets.ticketid ORDER BY dateline ) as Avg from ".KSQL_TPRFX."tickets WHERE isresolved = 1 AND ownerstaffid= ".$staff['staffid']." AND dateline > $_starttime AND dateline < $_endtime");
    $countResponseTime =0;
    foreach($_averages as $ticks) 
    {
        $avgResponseTime = $avgResponseTime + $ticks['Avg'];
        $Staff = $ticks['Staff'];
        $countResponseTime ++;
    }
    $_averages =$db->fetch_array("SELECT ownerstaffname as Staff,ticketid, ( resolutionseconds / 60 ) AS Resolution FROM ".KSQL_TPRFX."tickets WHERE isresolved = 1 AND ownerstaffid = ".$staff['staffid']." AND dateline > $_starttime AND dateline < $_endtime");
    $countResolveTime =0;
    foreach($_averages as $ticks) 
    {
        $avgResolveTime = $avgResolveTime + $ticks['Resolution'];
        $Staff = $ticks['Staff'];
        $countResolveTime ++;
    }

    if ($countResponseTime!=0) array_push($averageResponseTime, array("Staff"=> $Staff, "Avg" =>$avgResponseTime/$countResponseTime));
    if ($countResolveTime!=0)array_push($averageResolveTime, array("Staff"=> $Staff, "Avg" =>$avgResolveTime/$countResolveTime));  
}

?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
          <div class="col-lg-12 ibox-title">
              <h2> Overview of closed cases from [<?php echo unixtodate($_starttime);?>] to [<?php echo unixtodate($_endtime);?>] </h2>
			  <div class="col-lg-2">
                    <div class="ibox float-e-margins">
                    <div class="ibox-title">
                            <h5>Closed tickets for last week</h5>
                    <div class="ibox-content">
                            <div class="flot-chart">
                                <div class="flot-chart-pie-content" id="flot-pie-chart"></div>
                            </div>
                        </div>
                    </div></div>
               </div>
               <div class="col-lg-5">
                    <div class="ibox float-e-margins">
                     <div class="ibox-title">
                            <h5>Average response time for last week </small></h5>
                                        <div class="ibox-content">
                            <div class="flot-chart">
                                <div class="flot-chart-content" id="AvgResponseTime"></div>
                            </div>
                    </div></div>
                    </div>
               </div>
			  <div class="col-lg-5">
                    <div class="ibox float-e-margins">
                                         <div class="ibox-title">
                            <h5>Average first response time for last week </small></h5>
                                       <div class="ibox-content">
                            <div class="flot-chart">
                                <div class="flot-chart-content" id="AvgResolveTime"></div>
                            </div>
                            </div>
                    </div>
                    </div>
               </div>

         </div>
    </div>

	

    <div class="row">
                <div class="col-sm-12 ibox float-e-margins" >
				<div class="ibox-title">
                        <h5>Breakdown of closed cases from [<?php echo unixtodate($_starttime);?>]</h5>
                         <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                         </div>
    
                        <div class="ibox-content">
                        

 

  <?php $_result = array();
        $_count = 0;
        $_noclass = 0;
        $_class = '';
    $query = "select ticketid, subject,ownerstaffname,firstresponsetime,averageresponsetime,timeworked,totalreplies,resolutionseconds  from ".KSQL_TPRFX."tickets where swtickets.DepartmentTitle = 'CET' AND ticketstatustitle='Closed'  and resolutiondateline > ".$_starttime." order by ownerstaffname,ticketid";
    
       $rows = $db->query($query);
       while ($record = $db->fetch($rows))
        {
            $_result[] = $record;
        }
        
        $_html = '
        <table cellpadding="2" cellspacing="1" border="0" style="width: 100%">
    	<tr>
        	<td style="width: 50px; border-left: none;" class="title">ID</td>
            <td style="text-align: left; padding-left: 10px;" class="title">Subject</td>
            <td style="text-align: left; padding-left: 10px;" class="title">Owner</td>
            <td style="text-align: left; padding-left: 10px;" class="title">First Response Time</td>
            <td style="text-align: left; padding-left: 10px;" class="title">Average Response Time</td>
            <td style="text-align: left; padding-left: 10px;" class="title">Time Worked</td>
            <td style="text-align: left; padding-left: 10px;" class="title">Total replies</td>
            <td style="text-align: left; padding-left: 10px;" class="title">Resolution time</td>
        </tr>
        ';
        
        // Loop results
        $_count = count($_result);
        $_noclass = $_count - 1;

        for($i=0; $i<$_count; $i++){
            
            if(($i%2) == 0){
                $_class = 'odd';
            }else{
                $_class = 'even';
            }
			
                $_html .= '
                <tr>
                	<td style="width: 50px; border-left: none; border-bottom: none;" class="'.$_class.'">#'.$_result[$i]['ticketid'].'</td>
                    <td style="text-align: left; padding-left: 10px; border-bottom: none;" class="'.$_class.'">'.$_result[$i]['subject'].'</td>
                    <td style="text-align: left; padding-left: 10px; border-bottom: none;" class="'.$_class.'">'.$_result[$i]['ownerstaffname'].'</td>
                    <td style="text-align: left; padding-left: 10px; border-bottom: none;" class="'.$_class.'">'.format_seconds($_result[$i]['firstresponsetime']).'</td>
                    <td style="text-align: left; padding-left: 10px; border-bottom: none;" class="'.$_class.'">'.format_seconds($_result[$i]['averageresponsetime']).'</td>
                    <td style="text-align: left; padding-left: 10px; border-bottom: none;" class="'.$_class.'">'.format_seconds($_result[$i]['timeworked']).'</td>
                    <td style="text-align: left; padding-left: 10px; border-bottom: none;" class="'.$_class.'">'.$_result[$i]['totalreplies'].'</td>
                    <td style="text-align: left; padding-left: 10px; border-bottom: none;" class="'.$_class.'">'.format_seconds($_result[$i]['resolutionseconds']).'</td>
                </tr>
                ';
        }

        $_html .= '</table>';
        
        echo $_html;
        
        unset($_result);
        unset($_count);
        unset($_html);
        unset($_noclass);

?>
                        </div>
                    </div>
           
     </div>	
	    <div class="row">
          <div class="col-lg-12 ibox-title">
              <h2>New cases in last 6 weeks by product</h2>
			  <div class="col-lg-2">
                    <div class="ibox float-e-margins">
                    <div class="ibox-title">
                            <h5>In pie chart</h5>
                    <div class="ibox-content">
                            <div class="flot-chart">
                                <div class="flot-chart-pie-content" id="flot-newcases-chart"></div>
                            </div>
                        </div>
                    </div></div>
               </div>
			   <div class="col-lg-10">
                    <div class="ibox float-e-margins">
                     <div class="ibox-title">
                            <h5>In bar chart </small></h5>
                                        <div class="ibox-content">
                            <div class="flot-chart">
                                <div class="flot-chart-content" id="newcases"></div>
                            </div>
                    </div></div>
                    </div>
               </div>
			</div>
		</div>
		
		   
</div>
<script>

new Chartist.Bar('#AvgResponseTime', {
          labels: [<?php
            $i =1;
            foreach($averageResponseTime as $record)
            {
                if($i>1)echo","; 
                echo "'".$record['Staff']."'";
                $i++;
            }?>],
        series:[<?php
            $i =1;
            foreach($averageResponseTime as $record)
            {
                if($i>1)echo","; 
                echo $record['Avg'];
                $i++;
            }?>]},
    {
        distributeSeries: true,  axisY: {labelInterpolationFnc: function(value){return toHHMMSS(value);}
    }
});
new Chartist.Bar('#newcases', {
          labels: [<?php
            $i =1;
            foreach($queryLastSixWeeksNewByProductresult as $record)
            {
                if($i>1)echo","; 
                echo "'".$record['prd']."'";
                $i++;
            }?>],
        series:[<?php
            $i =1;
            foreach($queryLastSixWeeksNewByProductresult as $record)
            {
                if($i>1)echo","; 
                echo $record['cnt'];
                $i++;
            }?>]},
    {
        distributeSeries: true,  
});



new Chartist.Bar('#AvgResponseTime', {
          labels: [<?php
            $i =1;
            foreach($averageResponseTime as $record)
            {
                if($i>1)echo","; 
                echo "'".$record['Staff']."'";
                $i++;
            }?>],
        series:[<?php
            $i =1;
            foreach($averageResponseTime as $record)
            {
                if($i>1)echo","; 
                echo $record['Avg'];
                $i++;
            }?>]},
    {
        distributeSeries: true,  axisY: {labelInterpolationFnc: function(value){return toHHMMSS(value);}
    }
});

new Chartist.Bar('#AvgResolveTime', {
          labels: [<?php
            $i =1;
            foreach($averageResolveTime as $record)
            {
                if($i>1)echo","; 
                echo "'".$record['Staff']."'";
                $i++;
            }?>],
        series:[<?php
            $i =1;
            foreach($averageResolveTime as $record)
            {
                if($i>1)echo","; 
                echo $record['Avg'];
                $i++;
            }?>]},
    {
        distributeSeries: true,  axisY: {labelInterpolationFnc: function(value){return toHHMMSS(value);}
    }
});

$(function() {
    var data = [
        <?php
        $colorIndex = 0;
        foreach($_staffList as $staff)
        {
             $result =  $db->fetch_array("SELECT ownerstaffname as Staff, COUNT(".KSQL_TPRFX."tickets.ticketmaskid) AS 'Tickets' FROM ".KSQL_TPRFX."tickets RIGHT JOIN ".KSQL_TPRFX."ticketstatus ON ".KSQL_TPRFX."tickets.ticketstatusid = ".KSQL_TPRFX."ticketstatus.ticketstatusid RIGHT JOIN ".KSQL_TPRFX."departments ON ".KSQL_TPRFX."departments.departmentid = ".KSQL_TPRFX."tickets.departmentid WHERE ".KSQL_TPRFX."ticketstatus.title = 'Closed' AND ".KSQL_TPRFX."tickets.ownerstaffid =". $staff['staffid']." AND dateline > $_starttime AND dateline < $_endtime GROUP BY ownerstaffname");
                $i =1;
                    foreach($result as $stat)
                    {
                        if($i>1)echo","; 
                        echo"{label: \"".$stat["Staff"]." (".$stat["Tickets"].")\",data: ".$stat["Tickets"].",color: \"#".$colors[$colorIndex]."\"},";
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
    var data = [
        <?php
        $colorIndex = 0;
        
            $queryLastSixWeeksNewByProductresult = $db->fetch_array($queryLastSixWeeksNewByProduct);
			$i =0;
                    foreach($queryLastSixWeeksNewByProductresult as $stat)
                    {
                       
                        echo"{label: \"".$stat["prd"]." (".$stat["cnt"].")\",data: ".$stat["cnt"].",color: \"#".$colors[$colorIndex]."\"},";
                        $colorIndex++;
                    }
        
        
        ?>];

    var plotObj = $.plot($("#flot-newcases-chart"), data, {
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

</script>