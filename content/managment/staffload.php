<?php 
function generateDataString($sql,$db)
{
	$datastring = "";

	$rows = $db->query($sql);
	$index = 0;
	while ($record = $db->fetch($rows))
	{
	if ($index >0)$datastring.= " ,\n";
		$datastring.= "\"";
		$datastring.= $record["date"];
		$datastring.= "\":\"";
		$datastring.= $record["cnt"];
		$datastring.= "\"";
		$index++;
	}
	return $datastring;	
}

$listOfUsers = array();
$listOfUsersSQL = "SELECT staffid,staffgroupid, fullname FROM ".KSQL_TPRFX."staff where staffgroupid in(1,4) and staffid NOT IN (1,36) order by firstname";
$rows = $db->query($listOfUsersSQL);
$index = 0;
while ($record = $db->fetch($rows))
	{
	$listOfUsers[]=$record;
	}
$staffid = 4;
if(isset($_GET['staffid']))
	$staffid = $_GET['staffid'];

$sqlQuery = "SELECT DATE_FORMAT(from_unixtime(t.dateline),'%Y-%m-%d') as date, count(DATE_FORMAT(from_unixtime(t.dateline),'%Y-%m-%d')) as cnt FROM ".KSQL_TPRFX."tickets t where t.ownerstaffid='".$staffid."' group by date";
?>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12 ibox-title">
            <h2>  Tickets assigned last years </h2>
			
			<div class="row">
				<div class="col-sm-4">
					<select name="week" class="form-control m-b" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
					<?php
					
					for($i=0;$i<count($listOfUsers);$i++)
					{
					?>
					<option value ="?page=managment_staffload&staffid=<?php echo $listOfUsers[$i]['staffid']."\"";
					echo $staffid==$listOfUsers[$i]['staffid']?" SELECTED":"";?>><?php echo $listOfUsers[$i]['fullname']; ?></option>
					<?php
					}
					?>
					</select>
				</div>
			</div>
			<div class="col-lg-12">
                <div id="tpy" class="ibox float-e-margins"></div>
            </div>
		</div>
	</div>
</div>
                  
<script>

function monthPath(t0) {
  var t1 = new Date(t0.getFullYear(), t0.getMonth() + 1, 0),
      d0 = t0.getDay(), w0 = d3.time.weekOfYear(t0),
      d1 = t1.getDay(), w1 = d3.time.weekOfYear(t1);
  return "M" + (w0 + 1) * cellSize + "," + d0 * cellSize
      + "H" + w0 * cellSize + "V" + 7 * cellSize
      + "H" + w1 * cellSize + "V" + (d1 + 1) * cellSize
      + "H" + (w1 + 1) * cellSize + "V" + 0
      + "H" + (w0 + 1) * cellSize + "Z";
}

var width = 960,
    height = 136,
    cellSize = 17; // cell size

var percent = d3.format(".d%"),
    format = d3.time.format("%Y-%m-%d");

var color = d3.scale.quantize()
    .domain([-10, 10])
    .range(d3.range(11).map(function(d) { return "q" + d + "-11"; }));

//CET////////////////////////////////////////////////////////////////////////
var svg = d3.select("body").select("#tpy").selectAll("svg")
    .data(d3.range( 2015, 2018)) 
  .enter().append("svg")
    .attr("width", width)
    .attr("height", height)
    .attr("class", "RdYlGn")
  .append("g")
    .attr("transform", "translate(" + ((width - cellSize * 53) / 2) + "," + (height - cellSize * 7 - 1) + ")");

svg.append("text")
    .attr("transform", "translate(-6," + cellSize * 3.5 + ")rotate(-90)")
    .style("text-anchor", "middle")
    .text(function(d) { return d; });

var rect = svg.selectAll(".day")
    .data(function(d) { return d3.time.days(new Date(d, 0, 1), new Date(d + 1, 0, 1)); })
  .enter().append("rect")
    .attr("class", "day")
    .attr("width", cellSize)
    .attr("height", cellSize)
    .attr("x", function(d) { return d3.time.weekOfYear(d) * cellSize; })
    .attr("y", function(d) { return d.getDay() * cellSize; })
    .datum(format);

rect.append("title")
    .text(function(d) { return d; });

svg.selectAll(".month")
    .data(function(d) { return d3.time.months(new Date(d, 0, 1), new Date(d + 1, 0, 1)); })
  .enter().append("path")
    .attr("class", "month")
    .attr("d", monthPath);

var data =  {<?php echo generateDataString($sqlQuery,$db);?>};
  rect.filter(function(d) { return d in data; })
      .attr("class", function(d) { return "day " + color(data[d]); })
    .select("title")
      .text(function(d) { return d + ": " + percent(data[d]); });

	  
	  

</script>



