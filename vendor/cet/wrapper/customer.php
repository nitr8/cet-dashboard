<?php
function GetAllCustomers($conn, $username)
{
	$result = array ();

	$retval = mysql_query( "SELECT * From ".MYSQL_DB.".Customer c left join CustomersToUser cu on c.CustomerId = cu.CustomerId where cu.username='".$username."' AND cu.displayed=1" , $conn );
	while ($row = mysql_fetch_array($retval))
	{
			array_push($result,$row);
	}
	return $result;
}
?>