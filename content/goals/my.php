<?php $listOfGoals= array();
$recurrence = "1";

$retval = mysql_query( "SELECT id FROM ".MYSQL_DB.".uf_user where user_name='".$userName."'", $conn );
while ($row = mysql_fetch_array($retval))
{
	$userid = $row['id'];
}

if(isset($_GET['recurrence']))
	$recurrence =$_GET['recurrence'];

if(isset($_GET['complete']))
{
	
	$updatesql ="Insert into ".MYSQL_DB.".GoalCompletion (idGoal,submitted) VALUES";
	$updatesql.="(".$_GET['complete'].",NOW())";
	
	mysql_query( $updatesql, $conn );
	
}
$retval = mysql_query( "SELECT *  FROM ".MYSQL_DB.".Goals g left join uf_user u on g.userid = u.id where u.user_name='".$userName."' AND g.recurrence=".$recurrence , $conn );
while ($row = mysql_fetch_array($retval))
{
	array_push($listOfGoals,$row);
}
?>


<div class="gray-bg wrapper wrapper-content">
  <div class="row">
    <div class=" col-lg-12 ibox-title">
      <h2>
        List of goals for <?php echo "'".$userName."'"; //echo $updatesql;?>
		<a class="btn btn-w-sm btn-primary pull-right" href="index.php?page=goals_new&userid=<?php echo $userid;?>">+ Add new goal</a>
      </h2>
	<div class="ibox float-e-margins">
            <div class="ibox-title text-center">
				<p>
                    <a href="index.php?page=goals_my&recurrence=1"><button class="btn <?php if($recurrence=="1") echo "btn-outline"; else "btn-outline"; ?>  btn-danger" type="button">Daily</button></a>
                    <a href="index.php?page=goals_my&recurrence=2"><button class="btn <?php if($recurrence=="2") echo "btn-outline"; else "btn-outline"; ?>  btn-warning" type="button">Weekly</button></a>
                    <a href="index.php?page=goals_my&recurrence=3"><button class="btn <?php if($recurrence=="3") echo "btn-outline"; else "btn-outline"; ?>  btn-info" type="button">Monthly</button></a>
                    <a href="index.php?page=goals_my&recurrence=4"><button class="btn <?php if($recurrence=="4") echo "btn-outline"; else "btn-outline"; ?>  btn-success" type="button">Yearly</button></a>
                </p>
            </div>
  <div class="ibox-content">
			<?php 
			if(count($listOfGoals)==0)
			{
			echo "<p class=\"text-center \">No goals found it this category !</p>";
			echo "<p class=\"text-center \"><a class=\" btn btn-w-sm btn-primary\" href=\"index.php?page=goals_new&userid=".$userid."\">Add new goal</a></p>";
			
			}
			else
			for($i=0;$i<count($listOfGoals);$i++)
			{ 
				$recSQL = "";
				switch($listOfGoals[$i]['recurrence'])
					{
						case "1":
						$recSQL ="(NOW() - INTERVAL 1 DAY)";
						break;
						case "2":
						$recSQL ="(NOW() - INTERVAL 7 DAY)";
						break;
						case "3":
						$recSQL ="(NOW() - INTERVAL 30 DAY)";
						break;
						case "4":
						$recSQL ="(NOW() - INTERVAL 365 DAY)";
						break;
					}
					$completed = mysql_num_rows(mysql_query("SELECT * FROM ".MYSQL_DB.".GoalCompletion where idGoal ='".$listOfGoals[$i]['idGoals']."' AND submitted > ".$recSQL,$conn));
			?>
                
                          <div class="well well-lg">
						
                              <h3>
						    <a href="index.php?page=goals_my&recurrence=<?php echo $recurrence;?>&complete=<?php echo $listOfGoals[$i]['idGoals'];?>"> 
							<button class="btn btn-info btn-circle btn-lg pull-left" type="button"><i class="fa fa-check"></i></button></a>
							
							<?php 
							$completedprc=0;
							if($listOfGoals[$i]['completionAmount']!=0)
								$completedprc	= $completed / $listOfGoals[$i]['completionAmount'] * 100;
							?>
							
                                  <?php echo "#".$listOfGoals[$i]['idGoals'] ." - ".$listOfGoals[$i]['name']?><button class="btn btn-outline btn-lg btn-danger pull-right" type="button"><?php echo $completed . "/".$listOfGoals[$i]['completionAmount']?></button>
                        
						</h3>
				
						<!--div class="progress progress-striped active">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo $completedprc;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $completedprc;?>%">
                                    <span class="sr-only">40% Complete (success)</span>
                                </div>
                            </div-->
						
                              <?php echo $listOfGoals[$i]['description']?>
                          </div> 
                  
			<?php 
			}
			?></div>
             </div>         
		</div>
	</div>
 </div>