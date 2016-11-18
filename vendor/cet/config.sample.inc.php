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

$colors = array("1AB394", "79D2C0","D3D3D3","BABABA","453d3f","EE3333","33EE33","3333EE");

$queryProductCount = "select count(a.product)as cnt,a.product from (".
"SELECT". 
"       t.ticketid,t.timeworked,t.subject,cfo.optionvalue as product".
"  FROM ".KSQL_PRFX.".swtickets           t,".
"       ".KSQL_PRFX.".swcustomfieldlinks  cl,".
"        ".KSQL_PRFX.".swcustomfieldgroups cg,".
"       ".KSQL_PRFX.".swcustomfields      cf,".
"       ".KSQL_PRFX.".swcustomfieldvalues cv,".
"       ".KSQL_PRFX.".swcustomfieldoptions cfo".
" WHERE t.ticketstatustitle like 'Daily Checks'".
"  AND t.ticketid = cl.linktypeid".
"   AND cl.customfieldgroupid = cg.customfieldgroupid".
"   AND cg.customfieldgroupid = cf.customfieldgroupid".
"   AND cf.customfieldid = cv.customfieldid".
"   AND cv.typeid = t.ticketid and cv.customfieldid=9 ".
"   and cv.fieldvalue =cfo.customfieldoptionid) a group by a.product";

$queryTimeWorked= 
"SELECT". 
"    t.ticketid, t.timeworked, t.subject ".
"FROM".
"    ".KSQL_PRFX.".swtickets t,".
"    ".KSQL_PRFX.".swcustomfieldlinks cl,".
"    ".KSQL_PRFX.".swcustomfieldgroups cg,".
"    ".KSQL_PRFX.".swcustomfields cf,".
"    ".KSQL_PRFX.".swcustomfieldvalues cv ".
"WHERE".
"    t.ticketstatustitle LIKE 'Daily Checks'".
"        AND t.ticketid = cl.linktypeid".
"        AND cl.customfieldgroupid = cg.customfieldgroupid".
"        AND cg.customfieldgroupid = cf.customfieldgroupid".
"        AND cf.customfieldid = cv.customfieldid".
"        AND cv.typeid = t.ticketid".
"        AND cv.customfieldid = 9";
$queryLastSixWeeksNewByProduct= 
"select count(a.product)as cnt,a.product as prd from ( ".
"SELECT ".
"       t.ticketid,t.timeworked,t.subject,cfo.optionvalue as product ".
"  FROM ".KSQL_PRFX.".swtickets           t, ".
"       ".KSQL_PRFX.".swcustomfieldlinks  cl, ".
"       ".KSQL_PRFX.".swcustomfieldgroups cg, ".
"       ".KSQL_PRFX.".swcustomfields      cf, ".
"       ".KSQL_PRFX.".swcustomfieldvalues cv, ".
"       ".KSQL_PRFX.".swcustomfieldoptions cfo ".
" WHERE t.dateline > UNIX_TIMESTAMP() - 3628800 ".
"  AND t.ticketid = cl.linktypeid ".
"   AND cl.customfieldgroupid = cg.customfieldgroupid ".
"   AND cg.customfieldgroupid = cf.customfieldgroupid ".
"   AND cf.customfieldid = cv.customfieldid ".
"   AND cv.typeid = t.ticketid and cv.customfieldid=9  ".
"   and cv.fieldvalue =cfo.customfieldoptionid) a group by a.product ";

?>