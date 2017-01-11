<?php

// Enable authentication
define('USE_AUTH', '1');

// mySQL dashboard instance
define('MYSQL_SERVER', 'localhost');
define('MYSQL_USER', 'user');
define('MYSQL_PASS', 'password');
define('MYSQL_DB', 'dashboard');

// mySQL kayako database server (used for reading support info)
define('KSQL_SERVER', 'localhost');
define('KSQL_USER', 'user');
define('KSQL_PASS', 'password');
define('KSQL_DB', 'kayako');
define('KSQL_PRFX', 'kayako');
define('KSQL_TPRFX', KSQL_PRFX.".sw");

//Bamboo HR credentials 
define('BAMBOO_SECRET', '');
define('BAMBOO_LOGIN', '');
define('BAMBOO_PWD', '');
define('BAMBOO_COMPANY', '');

define('TICKETS_PER_PRODUCT','1');
define('TOP_TEN_TIME_TAKERS','2');
define('AGED_CASES','3');
define('URGENT_CASES','4');
define('SLA_BROKEN','5');
define('MANAGED_MIGRATIONS','6');
define('QFE_FIXES_PER_PRODUCT','7');
define('QFE_CLOSED','8');
define('NEW_ISSUES_PER_PRODUCT','9');
define('CLOSED_CASES','10');

$colors = array("1AB394", "79D2C0","D3D3D3","BABABA","453d3f","EE3333","33EE33","3333EE");

?>