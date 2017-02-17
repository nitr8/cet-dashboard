<script>
function confirmDelete(delUrl) {
  if (confirm("Are you sure you want to delete")) {
   document.location = delUrl;
  }
}
</script>

<?php
$retval = mysql_query( "SELECT id FROM ".MYSQL_DB.".uf_user where user_name='".$userName."'", $conn );
while ($row = mysql_fetch_array($retval))
{
	$userid = $row['id'];
}

if(isset($_GET['removeCondition'])&& is_numeric($_GET['removeCondition']))
{
	$updatesql ="delete from ".MYSQL_DB.".GoalCondition where idGoalCondition=".$_GET['removeCondition'];
	mysql_query( $updatesql, $conn );
}

if(isset($_GET['removeGoal'])&& is_numeric($_GET['removeGoal']))
{
	$updatesql ="delete from ".MYSQL_DB.".Goals where idGoals=".$_GET['removeGoal'];
	mysql_query( $updatesql, $conn );
		$updatesql ="delete from ".MYSQL_DB.".GoalCondition where idGoals=".$_GET['removeGoal'];
	mysql_query( $updatesql, $conn );
}

if(isset($_GET['updateConditions'])&& $_GET['updateConditions']=="true")
{
	$prc_lit="";
	$com_lit=" ,completeddate=null, completed = 0";	

	if(isset($_GET['percentCompleted'])&& is_numeric($_GET['percentCompleted']))
		$prc_lit=" ,percentCompleted = '".$_GET['percentCompleted']."'";

	if(isset($_GET['Iscompleted'])&&$_GET['Iscompleted']=="on")
		$com_lit=" ,completeddate=now(), completed = 1";
	
	$updatesql ="Update ".MYSQL_DB.".GoalCondition set updated =NOW(),description ='".$_GET['description']."'".$prc_lit.$com_lit." where idGoalCondition=".$_GET['idGoalCondition'];
	mysql_query( $updatesql, $conn );
}

if(isset($_GET['adjustGoal'])&& $_GET['adjustGoal']=="true")
{
	$private = 0;
	if(isset($_GET['private'])&&$_GET['private']=="on")
		$private="1";
	
	$updatesql ="Update ".MYSQL_DB.".Goals set name ='".$_GET['name']."', private ='".$private."',startDate ='".date( 'Y-m-d H:i:s',strtotime($_GET['startDate']))."',description ='".$_GET['description']."',enddate='".date( 'Y-m-d H:i:s',strtotime($_GET['endDate']))."',priority='".$_GET['priority']."',recurrence='".$_GET['reccurence']."',linkedgoal='6' where idGoals=".$_GET['idGoal'];
	mysql_query( $updatesql, $conn );
}

if(isset($_GET['addConditions'])&& $_GET['addConditions']=="true")
{
	$prc_lit="''";
	$com_lit=" ,completeddate=null, completed = 0";	

	if(isset($_GET['percentCompleted'])&& is_numeric($_GET['percentCompleted']))
		$prc_lit="'".$_GET['percentCompleted']."'";

	if(isset($_GET['Iscompleted'])&&$_GET['Iscompleted']=="on")
		$com_lit=" ,completeddate=now(), completed = 1";
	
	$updatesql ="Insert into ".MYSQL_DB.".GoalCondition (goalId,completed,completeddate,description,percentCompleted,createdBy,created,updated)VALUES";
	$updatesql.="('".$_GET['idGoal']."',0,null,'".$_GET['description']."',".$prc_lit.",".$userid.",NOW(),null)";
	
	mysql_query( $updatesql, $conn );
}

function getPriorityButton($id)
{
	switch($id)
	{
		case "0":
		return      "<button class=\"btn btn-outline btn-primary\" type=\"button\">LOW</button>";
		break;
		case "1":
		return      "<button class=\"btn btn-outline btn-info\" type=\"button\">LOW</button>";
		break;
		case "2":
		return     "<button class=\"btn btn-outline btn-warning\" type=\"button\">Medium</button>";
		break;
		case "3":
		return     "<button class=\"btn btn-outline btn-danger\" type=\"button\">High</button>";
		break;
	}
}

function formatPercentCompleted($i)
{
	if($i!=null &&$i < 25 )
		return "<div class=\"col-lg-3\"><p class=\"text-danger\">".$i."</p></div><div class=\"progress progress-mini\"><div class=\"progress-bar progress-bar-danger\" style=\"width: ".$i."%;\"></div></div>";
	else
	if($i!=null &&$i < 50 )

	return "<div class=\"col-lg-3\"><p class=\"text-warning\">".$i."</p></div><div class=\"progress progress-mini\"><div class=\"progress-bar progress-bar-warning\" style=\"width: ".$i."%;\"></div></div>";
	else
		if($i!=null &&$i <75 )

	return "<div class=\"col-lg-3\"><p class=\"text-info\">".$i."</p></div><div class=\"progress progress-mini\"><div class=\"progress-bar progress-bar-info\" style=\"width: ".$i."%;\"></div></div>";
	else
		if($i!=null &&$i <= 100 )

	return "<div class=\"col-lg-3\"><p class=\"text-success\">".$i."</p></div><div class=\"progress progress-mini\"><div class=\"progress-bar progress-bar-success\" style=\"width: ".$i."%;\"></div></div>";
	else
		if($i!=null &&$i > 100 )
	return "<div class=\"col-lg-3\"><p class=\"text-success\">".$i."</p></div><div class=\"progress progress-mini\"><div class=\"progress-bar progress-bar-success\" style=\"width: ".$i."%;\"></div></div>";
}

function formatDateForCondition($i)
{
	if($i==null ||$i=="" )
		return "<p class=\"text-danger\">N/A</p>";
	else
		return date('d.m.Y H:i',strtotime($i));
}

function getRecurrenceButton($id)
{
	switch($id)
	{
		case "0":
		return      "<button class=\"btn btn-outline btn-default\" type=\"button\">Not set</button>";
		break;
		case "1":
		return      "<button class=\"btn btn-outline btn-primary\" type=\"button\">Weekly</button>";
		break;
		case "2":
		return      "<button class=\"btn btn-outline btn-info\" type=\"button\">Monthly</button>";
		break;
		case "3":
		return      "<button class=\"btn btn-outline btn-warning\" type=\"button\">Yearly</button>";
		break;
	}
}

$listOfgoals= array();

$retval = mysql_query( "SELECT *  FROM ".MYSQL_DB.".Goals g left join uf_user u on g.userid = u.id where u.user_name='".$userName."'", $conn );
while ($row = mysql_fetch_array($retval))
{
	array_push($listOfgoals,$row);
}
?>
<div class="gray-bg wrapper wrapper-content">
  <div class="row">
    <div class=" col-lg-12 ibox-title">
      <h2>
        List of goals for <?php echo "'".$userName."'"; //echo $updatesql;?>
		<a class="btn btn-w-sm btn-primary pull-right" href="index.php?page=goals_new&userid=<?php echo $userid;?>">+ Add new goal</a>
      </h2>
	  
      <?php 
for($i=0;$i<count($listOfgoals);$i++)
{
	$retval = mysql_query( "SELECT *  FROM ".MYSQL_DB.".uf_user where id='".$listOfgoals[$i]["assignedBy"]."'", $conn );
	$goalAssignedBy  ="";
	
	while ($row = mysql_fetch_array($retval))
	{
		$goalAssignedBy=$row["user_name"];
	}
	
	$listOfconditions= array();
	$retval = mysql_query( "SELECT *  FROM ".MYSQL_DB.".GoalCondition where goalid='".$listOfgoals[$i]["idGoals"]."' order by idGoalCondition asc", $conn );
	$totalcompletion =0;
	
	while ($row = mysql_fetch_array($retval))
	{
		$totalcompletion += $row["percentCompleted"];
		array_push($listOfconditions,$row);
	}
	
	if(count($listOfconditions) == 0)
		$totalcompletion = 0;
	else
	$totalcompletion = round ($totalcompletion / count($listOfconditions),1);
	?>
	</div>
	<div class="col-lg-12 ibox-title">
		<div class="ibox float-e-margins col-lg-12">
		
			<span class="label label-success">
				<?php echo "#".$listOfgoals[$i]["idGoals"]." </span><h5> ". $listOfgoals[$i]["name"]."</h5>&nbsp;<small>(".$totalcompletion."% conditions fullfilled)</small>";?>
				<?php echo "<span class=\"pull-right\">assigned by <b>".$goalAssignedBy."</b></span><br/>";?>
				<div class="ibox-tools">
				
				<a class="collapse-link">
					<i class="fa fa-chevron-up"></i>
				</a>
				<a class="dropdown-toggle" href="#" data-toggle="dropdown">
					<i class="fa fa-wrench"></i>
				</a>
				<ul class="dropdown-menu dropdown-user">
					<li>
					<a href="#">Config option 1</a>
					</li>
					<li>
					<a href="#">Config option 2</a>
					</li>
				</ul>
				<a class="close-link">
					<i class="fa fa-times"></i>
				</a>
				</div>

				<div class="ibox-content">
				<form class="form-horizontal" method="get">
					<div class="form-group">
					<label class="col-sm-1 control-label">Start date </label>
					<div class="col-sm-2">
						<input class="form-control" type="text" value ="<?php echo date('d.m.Y',strtotime($listOfgoals[$i]["startdate"]));?>" readonly/>
					</div>
					<label class="col-sm-1 control-label">End date </label>
					<div class="col-sm-2">
						<input class="form-control" type="text" value ="<?php echo date('d.m.Y',strtotime($listOfgoals[$i]["enddate"]));?>" readonly/>
					</div>
					<label class="col-sm-1 control-label">Priority</label>
					<div class="col-sm-1">
	
	
						<?php echo getPriorityButton($listOfgoals[$i]["priority"]);?>
					</div>
					<label class="col-sm-1 control-label">Reccurence</label>
					<div class="col-sm-1">
						<?php echo getRecurrenceButton($listOfgoals[$i]["recurrence"]);?>
					</div>
					<label class="col-sm-1 control-label">Linked goal </label>
					<div class="col-sm-1">
						<input class="form-control" type="text" value ="<?php echo $listOfgoals[$i]["linkedgoal"];?>" readonly/>
	
					</div>
					</div>
				<div class="form-group">
					<label class="col-sm-1 control-label">Description</label>
					<div class="col-sm-9">
						<input class="form-control" type="text" value ="<?php echo $listOfgoals[$i]["description"];?>" readonly/>
	
						</div>
					<div class="col-sm-1">
					
					
					<?php
	
					if($listOfgoals[$i]["private"]=="1") echo "<button class=\"btn btn-w-sm btn-warning\" type=\"button\">Private</button>";
					else
					echo "<button class=\"btn btn-w-sm btn-primary\" type=\"button\">Public</button>";
				
					?>
					</div>
					<div class="col-sm-1">
					<a class="btn btn-sm btn-primary" href="#modal-adjust-goal<?php echo $listOfgoals[$i]["idGoals"];?>" data-toggle="modal">&gt;&gt;</a>
					<div class="modal fade" id="modal-adjust-goal<?php echo $listOfgoals[$i]["idGoals"];?>" aria-hidden="true" style="display: none;">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-body">
												<div class="row">
													<div class="col-sm-12"><h3 class="m-t-none m-b">Edit new goal.</h3>
	
														<p>Please adjust following parameters.</p>
														<form role="form" action="index.php" method="get" name ="IDGOALAdjustFORM<?php echo $listOfgoals[$i]["idGoals"];?>">
															<div class="form-group">
																<label class="col-sm-2 control-label">Name</label> 
																<div class="col-sm-7">
																<input class="form-control" name="name" type="text" value ="<?php echo $listOfgoals[$i]["name"];?>" placeholder="Enter goal name">
																</div>
																<label class="col-sm-2 control-label">Private</label> 
																<div class="col-sm-1">
																<input type="checkbox" name="isPrivate" <?php echo $listOfgoals[$i]["private"]=="1"?"CHECKED":"";?>/>
																</div>
															</div>
															<div class="form-group">
															<label class="col-sm-2 control-label">Start date</label> 
																	<div class="col-sm-4">
																<input class="form-control" name="startDate" type="text" value="<?php echo date("d-m-Y",strtotime($listOfgoals[$i]["startdate"]));?>" placeholder="Enter date DD-MM-YYY">
																</div>
																<label class="col-sm-2 control-label">End date </label> 
																<div class="col-sm-4">
																<input class="form-control" name="endDate" type="text" value="<?php echo date("d-m-Y",strtotime($listOfgoals[$i]["enddate"]));;?>" placeholder="Enter date DD-MM-YYY">
																</div>
															</div>
															<div class="form-group">
															<label class="col-sm-2 control-label">Priority</label>
															<div class="col-sm-3">
	
																<div>
																	<label>
																	<input name="priority"  type="radio" value="1" <?php echo $listOfgoals[$i]["priority"]=="1"?"checked":"";?>> Low </label>
																	<label>
																	<input name="priority"  type="radio" value="2" <?php echo $listOfgoals[$i]["priority"]=="2"?"checked":"";?>> Medium </label>
																	<label>
																	<input name="priority"  type="radio" value="3" <?php echo $listOfgoals[$i]["priority"]=="3"?"checked":"";?>> High </label>
																</div>
	
															</div>
															<label class="col-sm-2 control-label">Reccurence</label>
															<div class="col-sm-3">
															<div>
																	<label>
																	<input name="reccurence"  type="radio" <?php echo $listOfgoals[$i]["recurrence"]=="1"?"checked":"";?> value="1"> Weekly </label>
																	<label>
																	<input name="reccurence"  type="radio" <?php echo $listOfgoals[$i]["recurrence"]=="2"?"checked":"";?> value="2"> Monthly </label>
																	<label>
																	<input name="reccurence"  type="radio" <?php echo $listOfgoals[$i]["recurrence"]=="3"?"checked":"";?> value="3"> Yearly </label>
																	<label>
																	<input name="reccurence"  type="radio" <?php echo $listOfgoals[$i]["recurrence"]=="0"?"checked":"";?> value="0"> Not set </label>
																</div>
															</div>
															<label class="col-sm-1 control-label">Link</label>
															<div class="col-sm-1">
																<input class="form-control" type="text" value ="<?php echo $listOfgoals[$i]["linkedgoal"];?>" />
	
															</div>
															</div>
															
															<div class="form-group">
															<label>Description</label> 
															<input class="form-control" name="description" type="text" value ="<?php echo $listOfgoals[$i]["description"];?>" placeholder="Enter description">
															</div>
															
															<div class="col-sm-12">
															<br/>
															<div class="form-group">
																<button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Save</strong></button>
															</div>
														</div>
														<input type="hidden" name = "page" value = "goals_overview"/>
														<input type="hidden" name = "adjustGoal" value="true"/> 
														<input type="hidden" name = "idGoal" value = "<?php echo $listOfgoals[$i]["idGoals"];?>"/> 
														</form>
													</div>
											</div>
										</div>
										</div>
									</div>
							</div>
					
					<a onclick="return confirm('Are you sure you want to delete?')" class="btn btn-sm btn-danger" href="index.php?page=goals_overview&removeGoal=<?php echo $listOfgoals[$i]["idGoals"];?>">X</a>

					</div>
					</div>
				</form>
				</div>
				<div class="ibox-content">
				<div class="row">
					<div class="col-lg-12">
					<div class="ibox float-e-margins">
						<h5>List of conditions for goal</h5>
						<div class="ibox-content">
						<?php 
						if(count($listOfconditions)==0)
							{
							echo "<p class=\"text-danger\">No condition defined, yet.</p>";
							}
							else{
						?>
						<table width ="100%">
							<tr>
							<th></th>
							<th class="text-center">Description</th>
							<th class="text-center"> % completed</th>
	
							<th class="text-center">Created</th>
							<th class="text-center">Updated</th>
							<th class="text-center">Completed</th>
							<th></th><th></th>
							</tr>
	
							<?php 
					
						for($c=0;$c<count($listOfconditions);$c++)
						{
						
							echo "<tr>";
							
							echo "<td><input type=\"checkbox\" ";
							if($listOfconditions[$c]["completed"] == "1")
							echo "checked ";
							echo " disabled readonly/></td>";
							echo "<td>".$listOfconditions[$c]["description"]."</td>";
							echo "<td class=\"text-center\">".formatPercentCompleted($listOfconditions[$c]["percentCompleted"])."</td>";
							echo "<td class=\"text-center\">".formatDateForCondition($listOfconditions[$c]["created"])."</td>";
							echo "<td class=\"text-center\">".formatDateForCondition($listOfconditions[$c]["updated"])."</td>";
							echo "<td class=\"text-center\">".formatDateForCondition($listOfconditions[$c]["completeddate"])."</td>";
							?><td>
	
								<div class="text-center">
									<a class="btn btn-primary btn-xs" href="#modal-form<?php echo $listOfgoals[$i]["idGoals"]."_". $listOfconditions[$c]["idGoalCondition"];?>" data-toggle="modal">&gt;&gt;</a>
									
									<div class="modal fade" id="modal-form<?php echo $listOfgoals[$i]["idGoals"]."_".$listOfconditions[$c]["idGoalCondition"];?>" aria-hidden="true" style="display: none;">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-body">
												<div class="row">
													<div class="col-sm-12"><h3 class="m-t-none m-b">Adjust goal condition</h3>
	
														<p>Please adjust description, completion or percentage. </p>
														<form role="form" action="index.php" method="get" name ="IDGOALFORM<?php echo $listOfgoals[$i]["idGoals"]."_".$listOfconditions[$c]["idGoalCondition"];?>">
															<div class="form-group"><label>Description</label> <input class="form-control" name="description" type="text" value="<?php echo $listOfconditions[$c]["description"];?>" placeholder="Enter description"></div>
															<div class="form-group"><div class="col-sm-4"><label>Percent completed</label></div>
															<div class="col-sm-2"> <input class="form-control" type="text" name="percentCompleted" value="<?php echo $listOfconditions[$c]["percentCompleted"];?>">
															</div><div class="col-sm-2"><label>Completed</label></div> <div class="col-sm-4"><input class="form-control" name="Iscompleted" type="checkbox" <?php if($listOfconditions[$c]["completed"] == "1")	 echo "checked "; ?>></div>
															</div>
															<div class="col-sm-12">
															<br/>
															<div class="form-group">
																<button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Submit</strong></button>
																</div></div>
															<input type="hidden" name = "page" value = "goals_overview"/>
															<input type="hidden" name = "updateConditions" value="true"/> 
															<input type="hidden" name = "idGoalCondition" value = "<?php echo $listOfconditions[$c]["idGoalCondition"];?>"/> 
														</form>
													</div>
											</div>
										</div>
										</div>
									</div>
							</div>
								</div>
							</td>
							<td>
							<a onclick="return confirm('Are you sure you want to delete?')" class="btn btn-danger btn-xs" href="index.php?page=goals_overview&removeCondition=<?php echo $listOfconditions[$c]["idGoalCondition"];?>">X</a>

							</td>
							<?php
							echo "</tr>";
						}?>
						</table><?php } ?>
							<div class="text-center">
							<br/>
								<a class="btn btn-sm btn-primary pull-right m-t-n-xs" href="#modal-form_new<?php echo $listOfgoals[$i]["idGoals"];?>" data-toggle="modal">+ add new condition</a>
								</div>                  
	
								<div class="modal fade" id="modal-form_new<?php echo $listOfgoals[$i]["idGoals"];?>" aria-hidden="true" style="display: none;">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-body">
												<div class="row">
													<div class="col-sm-12"><h3 class="m-t-none m-b">Add new goal condition</h3>
	
														<p>Please fill in  description, completion or percentage. </p>
														<form role="form" action="index.php" method="get" name ="IDGOALFORM<?php echo $listOfgoals[$i]["idGoals"];?>">
															<div class="form-group"><label>Description</label> <input class="form-control" name="description" type="text" placeholder="Enter description"></div>
															<div class="form-group"><div class="col-sm-4"><label>Percent completed</label></div>
															<div class="col-sm-2"> <input class="form-control" type="text" name="percentCompleted" value ="0">
															</div><div class="col-sm-2"><label>Completed</label></div> <div class="col-sm-4"><input class="form-control" name="Iscompleted" type="checkbox"></div>
															</div>
															<div class="col-sm-12">
															<br/>
															<div class="form-group">
																<button class="btn btn-sm btn-primary pull-right m-t-n-xs" type="submit"><strong>Add new condition</strong></button>
																</div></div>
															<input type="hidden" name = "page" value = "goals_overview"/>
															<input type="hidden" name = "addConditions" value="true"/> 
															<input type="hidden" name = "idGoal" value = "<?php echo $listOfgoals[$i]["idGoals"];?>"/> 
														</form>
													</div>
											</div>
										</div>
										</div>
									</div>
							</div>			
						</div>
					</div>
					</div>
	
				</div>
				</div>
			
		</div>
		<?php 
	}?>
   </div>
</div>
