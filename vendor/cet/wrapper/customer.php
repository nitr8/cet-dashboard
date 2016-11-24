<?php
function GetAllCustomers($conn)
{
	$result = array ();

	$retval = mysql_query( "SELECT * From ".MYSQL_DB.".Customer", $conn );
	while ($row = mysql_fetch_array($retval))
	{
			array_push($result,$row);
	}
	return $result;
}
?>