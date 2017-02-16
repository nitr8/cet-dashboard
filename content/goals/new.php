<?php
$listOfUsers= array();

$retval = mysql_query("SELECT * FROM ".MYSQL_DB.".uf_user", $conn );
while ($row = mysql_fetch_array($retval))
{
	array_push($listOfUsers,$row);
}



?>
<div class="wrapper wrapper-content">
  <div class="row">
    <div class="col-lg-12 ibox-title">
      <h2>
        Create a new goal
      </h2>
    </div>


    <div class="ibox-content">


      <form class="form-horizontal" method="get">
	  <div class="form-group">
          <label class="col-sm-1 control-label">User</label>
          <div class="col-sm-5">
			<select name="username" class="form-control m-b">
			<?php
			for ($i=0;$i<count($listOfUsers);$i++)
			{
			echo "<option value = \"".$listOfUsers[$i]["id"]."\"";
			if($listOfUsers[$i]["user_name"] == $userName)
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
          <label class="col-sm-1 control-label">Name</label>
          <div class="col-sm-5">
            <input class="form-control" type="text" />
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-1 control-label">Description</label>
          <div class="col-sm-11">
            <input class="form-control" type="text" />

          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-1 control-label">Start date </label>
          <div class="col-sm-2">
            <input class="form-control" type="text" />

          </div>
          <label class="col-sm-1 control-label">End date </label>
          <div class="col-sm-2">
            <input class="form-control" type="text"  />
          </div>
          <label class="col-sm-1 control-label">Priority</label>
          <div class="col-sm-1">

            <div>
				<label>
                <input name="priority"  type="radio" checked="" value="1"> Low </label>
				<label>
				<input name="priority"  type="radio" checked="" value="2" SELECTED> Medium </label>
				<label>
				<input name="priority"  type="radio" checked="" value="3"> High </label>
            </div>

          </div>
          <label class="col-sm-1 control-label">Reccurence</label>
          <div class="col-sm-1">
        <div>
				<label>
                <input name="reccurence"  type="radio" checked="" value="1"> Weekly </label>
				<label>
				<input name="reccurence"  type="radio" checked="" value="2"> Monthly </label>
				<label>
				<input name="reccurence"  type="radio" checked="" value="3"> Yearly </label>
				<label>
				<input name="reccurence"  type="radio" checked="" value="4" SELECTED> Not set </label>
            </div>
          </div>
          <label class="col-sm-1 control-label">Linked goal </label>
          <div class="col-sm-1">
            <input class="form-control" type="text" />

          </div>
        </div>
         </form>
      </div>
  </div>
</div>