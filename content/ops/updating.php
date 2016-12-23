<?php 

function updateDisplayStatus ($loggedUser,$customerID,$status,$connection)
{
	$retval = mysql_query("SELECT *FROM ".MYSQL_DB.".CustomersToUser  where username = '".$loggedUser."' AND CustomerId='".$customerID."'" , $connection);
	while ($row = mysql_fetch_array($retval))
	{
		$updatequery = "UPDATE ".MYSQL_DB.".CustomersToUser SET displayed='".$status."' WHERE username = '".$loggedUser."' AND CustomerId='".$customerID."'";
		$retval = mysql_query($updatequery , $connection );
	return;
	}
	$insertquery = "INSERT INTO ".MYSQL_DB.".CustomersToUser (username,CustomerId,displayed) VALUES ('".$loggedUser."','".$customerID."','".$status."') ";

	$retval = mysql_query($insertquery , $connection );
}

if(isset ($_GET['update']))
{
	$listOfcustomers= array();

	$retval = mysql_query( "SELECT c.*,cu.displayed  FROM ".MYSQL_DB.".Customer c  left join CustomersToUser cu on c.CustomerId = cu.customerId  ", $conn );
	while ($row = mysql_fetch_array($retval))
	{
		array_push($listOfcustomers,$row);
	}

		foreach ($listOfcustomers as $customer)
		{
	
		if(isset($_GET['CID'.$customer['CustomerId']]))
		{
			updateDisplayStatus($userName,$customer['CustomerId'],1,$conn);
		}
		else
		{
			updateDisplayStatus($userName,$customer['CustomerId'],0,$conn);
		}
	}
}

?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
          <div class="col-lg-12 ibox-title">
              <h2> Updating ... 
			  <meta http-equiv="refresh" content="2; url=index.php?page=ops_list" />
			  </h2>
			  <div class="col-lg-6">
			  </div>
		</div>
	</div>
</div>