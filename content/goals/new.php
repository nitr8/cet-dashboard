<?php
$updating = false;
$validForm = true;
$listOfUsers= array();

$retval = mysql_query("SELECT * FROM ".MYSQL_DB.".uf_user", $conn );
while ($row = mysql_fetch_array($retval))
{
	array_push($listOfUsers,$row);
	if($row["user_name"]==$userName)
	 $myuserId = $row["id"];
}

$userid= $myuserId;
$dateFrom= date("d-m-Y");
$dateTo=date('d-m-Y"', strtotime('+1 years'));
if(isset($_GET['userid'])&& is_numeric($_GET['userid']))
{
	$creatorId= $_GET["userid"];
	}
else	
	$creatorId= $myuserId;
	
$private = "0";
$priority = 1;
if(isset($_GET['priority']))
$priority = $_GET['priority'];
$name="New Goal";
$linkedGoal=null;
$private="0";
$completionAmount = 20;
if(isset($_GET['addNew'])&& $_GET['addNew']=="true")
{
	$updating=true;
	if(isset($_GET['name']))
		$name=$_GET['name'];

	if(isset($_GET['linkedGoal'])&& is_numeric($_GET['linkedGoal']))
		$linkedGoal="".$_GET['linkedGoal']."";
	if(isset($_GET['completionAmount'])&& is_numeric($_GET['completionAmount']))
		$completionAmount="".$_GET['completionAmount']."";
	if(isset($_GET['private'])&&$_GET['private']=="on")
		$private ="1";
		
	if(isset($_GET['dateFrom']))
		$dateFrom = date( 'Y-m-d H:i:s',strtotime($_GET['dateFrom']));
		
	if(isset($_GET['dateEnd']))
		$dateTo = date( 'Y-m-d H:i:s',strtotime($_GET['dateEnd']));
		
	$updatesql ="Insert into ".MYSQL_DB.".Goals (description,name,userid,private,linkedgoal,priority,recurrence,startdate,enddate,assignedBy,completionAmount)VALUES";
	$updatesql.="('".$_GET['description']."','".$name."',".$creatorId.",".$private.",".($linkedGoal==null?"null":$linkedGoal).",".$priority.",".$_GET['reccurence'].",'".$dateFrom."','".$dateTo."',".$myuserId.",".$completionAmount.")";
	
	mysql_query( $updatesql, $conn );
}


?>
<div class="wrapper wrapper-content">
  <div class="row">
    <div class="col-lg-6 ibox-title">
      <h2>
        Create a new goal <?php //echo $updatesql;?>
      </h2>
    </div>
    <div class="ibox-content col-lg-6 ">
	<?php 
	if ($validForm&& $updating)
	{
	echo "<h5>Updating ...</h5><meta http-equiv=\"refresh\" content=\"0; url=?page=goals_my\" />";
	}
	else
	{
	?>
      <form class="form-horizontal" method="get">
	  <div class="form-group">
          <label class="col-sm-2 control-label">User</label>
          <div class="col-sm-10">
			<select name="userid" class="form-control m-b">
			<?php
			for ($i=0;$i<count($listOfUsers);$i++)
			{
			echo "<option name=\"userid\" value = \"".$listOfUsers[$i]["id"]."\"";
			if($listOfUsers[$i]["id"] == $creatorId)
			echo " SELECTED";
			echo ">";
			echo $listOfUsers[$i]["user_name"] . " - " . $listOfUsers[$i]["display_name"];
			echo "</option>";
			}

			?>
          </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Name</label>
          <div class="col-sm-10">
            <input class="form-control" name ="name" type="text" placeholder="Enter goal name"/>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Description</label>
          <div class="col-sm-10">
            <input class="form-control" name="description" type="text" placeholder="Enter goal description"/>

          </div>
        </div>
        <div class="form-group">
          <!--label class="col-sm-1 control-label">Start date </label>
          <div class="col-sm-2">
            <input class="form-control" type="text"name="dateFrom" value="<?php echo $dateFrom;?>" placeholder="Enter start date" />

          </div>
          <label class="col-sm-1 control-label">End date </label>
          <div class="col-sm-2">
            <input class="form-control" type="text" name="dateEnd" value="<?php echo $dateTo;?>"placeholder="Enter end date" />
          </div
		  
          <label class="col-sm-2 control-label">Priority</label>
          <div class="col-sm-4">
            <div>
				<label>
                <input name="priority"  type="radio"  value="1"> Low </label>
				<label>
				<input name="priority"  type="radio"  value="2" CHECKED> Medium </label>
				<label>
				<input name="priority"  type="radio"  value="3"> High </label>
            </div>
          </div-->
          <label class="col-sm-2 control-label">Recurrence</label>
          <div class="col-sm-10">
			<div>
				<label>
				<input name="reccurence"  type="radio" value="1"CHECKED> Daily </label>
				<label>
				<input name="reccurence"  type="radio" value="2"> Weekly </label>
				<label>
				<input name="reccurence"  type="radio" value="3"> Monthly </label>
				<label>
				<input name="reccurence"  type="radio" value="4" > Yearly </label>
				<label>
				<input name="reccurence"  type="radio" value="5"> Not set </label>
            </div>
          </div>

			<input type="hidden" name = "page" value = "goals_new"/>
			<input type="hidden" name = "addNew" value="true"/> 
		
       
        </div>
		                             <div class="form-group">
														<label class="col-sm-2 control-label">Completion amount</label> 
														 <div class="col-sm-2">
														<input class="form-control" name="completionAmount" type="text" value ="<?php echo $completionAmount;?>" placeholder="number">
														</div>
															<!--label class="col-sm-2 control-label">Linked goal</label> 
														 <div class="col-sm-2">
														<input class="form-control" name="linkedGoal" type="text" value ="<?php echo $linkedGoal;?>" placeholder="Enter goal number or leave empty">
														</div>
														<label class="col-sm-2 control-label">Private</label> 
														 <div class="col-sm-1">
														 <input type="checkbox" name="isPrivate" <?php echo $private=="1"?"CHECKED":"";?>/>
														 </div-->
														</div>
		<div class="form-group">
                                                            <button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Add new Goal</strong></button>
                                                            </div></
         </form>
		 <?php
		 }
		 ?>
      </div>
  </div>
</div>