<?php
function GetAllLinkInforForCustomerID($conn, $customerId)
{
	$result = array ();

	$retval = mysql_query( "SELECT * From ".MYSQL_DB.".LinkInfo, ".MYSQL_DB.".Customer WHERE Customer.CustomerId=LinkInfo.CustomerId AND LinkInfo.CustomerId='".$customerId."'", $conn );
	while ($row = mysql_fetch_array($retval))
	{
		array_push($result,$row);
	}
	return $result;
}
?>