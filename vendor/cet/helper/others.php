<?php
function secondsToTime($seconds)
{
    // extract hours
    $hours = floor($seconds / (60 * 60));
    // extract minutes
    $divisor_for_minutes = $seconds % (60 * 60);
    $minutes = floor($divisor_for_minutes / 60);
    // extract the remaining seconds
    $divisor_for_seconds = $divisor_for_minutes % 60;
    $seconds = ceil($divisor_for_seconds);

    // return the final array
    $obj = array(
        "h" => (int) $hours,
        "m" => (int) $minutes,
        "s" => (int) $seconds,
    );
    return  $hours . ":".$minutes.":".$seconds;
}

function authenticateUser($user,$password)
{
	if(USE_AUTH)
	{
		$returnvalue=false;
		$link =mysqli_connect(MYSQL_SERVER,MYSQL_USER,MYSQL_PASS,MYSQL_DB);
	
		/* check connection */
		if (mysqli_connect_errno()) {
			echo("Connect failed: ". mysqli_connect_error());
			exit();
		}
		
		/* Select queries return a resultset */
		if ($result = mysqli_query($link, "SELECT password From uf_user WHERE uf_user.user_name = '".$user."' and flag_enabled='1'")) 
		{
			while ($row = mysqli_fetch_assoc($result)) 
			{
				$returnvalue = ps($password, $row['password']);
				break;
			}
			mysqli_free_result($result);
		}	
		return $returnvalue;
	}
		
	return true;
}				
       
function ps($password, $hash) 
{
        $ret = crypt($password, $hash);
        if ( _strlen($ret) != _strlen($hash) || _strlen($ret) <= 13) 
        {
            return false;
        }

        $status = 0;
        for ($i = 0; $i < _strlen($ret); $i++) 
        {
            $status |= (ord($ret[$i]) ^ ord($hash[$i]));
        }

        return $status === 0;
  
    } 

function formatBytes($size, $precision = 2)
{
    $base = log($size, 1024);
    $suffixes = array('', 'KiB', 'MiB', 'GiB', 'TiB');   

    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}

function _strlen($binary_string) 
{
           if (function_exists('mb_strlen')) {
               return mb_strlen($binary_string, '8bit');
           }
           return strlen($binary_string);
    }

function _substr($binary_string, $start, $length) 
{
       if (function_exists('mb_substr')) {
           return mb_substr($binary_string, $start, $length, '8bit');
       }
       return substr($binary_string, $start, $length);
   }

function isActive($prefix)
{
if(!isset($_GET["page"]))
    return;
 if(startsWith($_GET["page"], $prefix))
    echo "active";
}
function isActiveEmpty()
{
if(!isset($_GET["page"]))

    echo "active";
}
function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
}

function endsWith($haystack, $needle) {
    // search forward starting from end minus needle length characters
    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
}

function gettoday()
{
    $_today = date('j');
    return $_today;
}

function getmonth()
{
    $_month = date('n');
    
    return $_month;
}

function getlastmonth(){
    $_month = date('n');
    
    if($_month == 1){
        $_month = 12;
    }else{
        $_month = $_month - 1;
    }
    
    return $_month;
}

function getlastmonthyr(){
    $_month = date('n');
    $_year = date('Y');
    
    if($_month == 1){
        $_year = $_year - 1;
    }
    
    return $_year;
}

function getyear(){
    $_year = date('Y');
    
    return $_year;
}

function isleap($_year){
    if(($_year % 4) == 0){
        $_isleap = true;
    }
            
    return $_isleap;
}

function gettodaydate(){
    $_today = date('Y/m/d');
    
    return $_today;
}

function getyesterdaydate(){
    $_today = date('Y/m/d',strtotime("-1 days"));
    
    return $_today;
}
function getdays($_month, $_year){
    $_lastday = cal_days_in_month (CAL_GREGORIAN, $_month, $_year);
            
    return $_lastday;
}

function datetoday(){
   $_date = date('j M Y, h:i A');
   $_date = strtotime($_date);
   
   return $_date;
}

function dateyesterday(){
   $_date = date('d-m-Y', time() - 60 * 60 * 24);
   return $_date;
}

function createunix($_day, $_month, $_year){
   $_unixtime = mktime(0, 0, 0, $_month, $_day, $_year);
   
   return $_unixtime;
}


function createfirstdayunix($_month, $_year){
   $_firstdayunix = mktime(0, 0, 0, $_month, 1, $_year);
   
   return $_firstdayunix;
}

function createlastdayunix($_day, $_month, $_year)
{
   $_lastdayunix = mktime(23, 59, 59, $_month, $_day, $_year);
   
   return $_lastdayunix;
}


function endofdayunix($_day, $_month, $_year)
{
   $_lastdayunix = mktime(23, 59, 59, $_month, $_day, $_year);
   
   return $_lastdayunix;
}

function startofdayunix($_day, $_month, $_year)
 {
   $_lastdayunix = mktime(0, 0, 0, $_month, $_day, $_year);
   
   return $_lastdayunix;
}

function unixtotime($_string)
{
   $_string = date('j M Y, h:i A', $_string);
   return $_string;
}
  function unixtodate($_string)
  {
   $_string = date('j M Y', $_string);
   return $_string;
}

function displayinhours($_string)
{
   $_hours = floor($_string/60);
   $_minutes = $_string - ($_hours * 60);
   
   $_string = $_hours.".".$_minutes;
   
   return $_string;
} 

function format_seconds($t,$f=':') // t = seconds, f = separator 
{
  return sprintf("%02d%s%02d%s%02d", floor($t/3600), $f, ($t/60)%60, $f, $t%60);
}



?>