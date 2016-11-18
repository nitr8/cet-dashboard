<?php

function GetAllLinkInforForCustomerID($db, $customerId)
{
    $result = $db->fetch_array("SELECT * From ".MYSQL_DB.".LinkInfo, ".MYSQL_DB.".Customer WHERE Customer.CustomerId=LinkInfo.CustomerId AND LinkInfo.CustomerId='".$customerId."'");
    return $result;
}