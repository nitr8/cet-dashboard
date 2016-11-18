<?php
function GetAllCustomers(  $db )
{
    $result = $db->fetch_array("SELECT * From ".MYSQL_DB.".Customer");
    return $result;
}

?>