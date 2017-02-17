<?php
$index = 0;
$listOfUsers= array();

$retval = mysql_query("SELECT * FROM ".MYSQL_DB.".uf_user where user_name <> 'root'", $conn );
while ($row = mysql_fetch_array($retval))
{
	array_push($listOfUsers,$row);
}




?>

<div class="wrapper wrapper-content">
	<div class="row">
		<?php 
		for($i=0;$i<count($listOfUsers);$i++)
		{
		$listOfGoals= array();

			$retval = mysql_query("SELECT * FROM ".MYSQL_DB.".Goals where userid='".$listOfUsers[$i]['id']."'", $conn );
			while ($row = mysql_fetch_array($retval))
			{
				array_push($listOfGoals,$row);
			}
		?>
			<div class="ibox collapsed">
                <div class="ibox-title ">
                    <h5><?php echo $listOfUsers[$i]["display_name"]; ?> 
					 (<?php echo count($listOfGoals);?> goals)</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content  no-padding">
				<?php 
				for($g=0;$g<count($listOfGoals);$g++)
				{

				$listOfConditions= array();

				$retval = mysql_query("SELECT * FROM ".MYSQL_DB.".GoalCondition where goalId=".$listOfGoals[$g]["idGoals"], $conn );
				while ($row = mysql_fetch_array($retval))
				{
					array_push($listOfConditions,$row);
				}
				?>
											
										
						<div class="col-lg-6">
						
						
						<div class="panel-group" id="accordion<?php echo $index;?>">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h6 class="panel-title">
                                                <a href="#collapseOne<?php echo $index;?>" data-toggle="collapse" data-parent="#accordion<?php echo $index;?>">#
												<?php echo $listOfGoals[$g]["idGoals"]." - ".$listOfGoals[$g]["name"]. "(".count($listOfConditions)." conditions)";?></a>
                                            </h6>
                                        </div>
                                        <div class="panel-collapse collapse" id="collapseOne<?php echo $index;?>">
                                            <div class="panel-body">
                                            <p class="text-info text-center"><?php echo $listOfGoals[$g]["description"];?></p>
											<div class="hr-line-dashed"></div>
												 <div class="text-center">
									<?php echo getPriorityButton($listOfGoals[$g]["priority"]);?>
									<?php echo getRecurrenceButton($listOfGoals[$g]["recurrence"]);?>
													<?php
	
					if($listOfGoals[$g]["private"]=="1") echo "<button class=\"btn btn-w-sm btn-warning\" type=\"button\">Private</button>";
					else
					echo "<button class=\"btn btn-w-sm btn-primary\" type=\"button\">Public</button>";
				
					?>
									</div>
									    <div class="hr-line-dashed"></div>
									<div class="panel-group" >
									<?php
									if(count($listOfConditions)==0)
									{
										echo "<p class=\"text-danger\">No conditions defined, yet</p>";
									}else
									{?>
										
											<table width ="100%">
											<tr>
											<th></th>
											<th class="text-center">Description</th>
											<th class="text-center"> % of task completed</th>
											<th class="text-center">Completed</th>
											</tr>
										<?php 
										for($c=0;$c<count($listOfConditions);$c++)
										{
												echo "<tr>";
												
												echo "<td><input type=\"checkbox\" ";
												if($listOfConditions[$c]["completed"] == "1")
												echo "checked ";
												echo " disabled readonly/></td>";
												echo "<td>".$listOfConditions[$c]["description"]."</td>";
												echo "<td class=\"text-center\">".formatPercentCompleted($listOfConditions[$c]["percentCompleted"])."</td>";

												echo "<td class=\"text-center\">".formatDateForCondition($listOfConditions[$c]["completeddate"])."</td>";
											
											
										}
										echo "</table>";
										}
										?>
									
                                </div>
								</div>
							</div>
						</div>
					</div>

                </div>							
				<?php 
				$index++;
			}
			?>
                                 
                 </div>
             </div>
		<?php 
		}
		?>							
	</div>
</div>