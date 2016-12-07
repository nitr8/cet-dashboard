<?php

function getColorsForCharts()
{
//we are using 2 types of charts - for pie chars and graph colors are defined here,
// for chartist its in chartist.min.css - class name  ct-series-a, ct-series-b ...etc
//
// see this for more http://flatuicolors.com
//
//#2ecc71 - emerald
//#d35400 - punkin 

return "colors: [
	/* #3498db - peter river - ArchiveShuttle */
	\"#3498db\",
	/* #2980b9 - belize hole - AS .cloud */
	\"#2980b9\",
	/* MS .cloud & FD ??? FIX */
	\"#d35400\",
	/* #16a085 - green sea  - FlightDeck */
	\"#16a085\",
	/* #f1c40f - sun flower - MS .cloud - graph */
	\"#f1c40f\",
	/* #2c3e50  - midnight blue - tools */
	\"#2c3e50\",
	/* #c0392b - pomegranate - others */
	\"#c0392b\",
	/* #e67e22 - carrot - MailboxShuttle */
	\"#e67e22\",
	/* #8e44ad - wisteria - ADAM */
	\"#8e44ad\",
	/* WTF - PINK */
	\"#FF1493\",
	/* WTF - PINK */
	\"#FF1493\"
	],";
}


function generateTableFromResult ($_result,$displayOrganization, $displayStatus)
{
	$_count = count($_result);
		$_html=	'	
        <table cellpadding="2" cellspacing="1" border="0" style="width: 100%">
    	<tr>
        	<td style=" border-left: none;" class="title">Id</td>
			<td style=" border-left: none;" class="title">Owner</td>
			<td style=" border-left: none;" class="title">Opened</td>
			<td style=" border-left: none;" class="title">Case</td>';
			if ($displayOrganization) 
				$_html.='<td style=" border-left: none;" class="title">Organization</td>';			
		$_html .='
			<td style=" border-left: none;" class="title">First Reponse Time</td>
			<td style=" border-left: none;" class="title">Average Response Time</td>
			<td style=" border-left: none;" class="title">Total replies</td>
			<td style=" border-left: none;" class="title">Priority</td>';

			if ($displayStatus) 
				$_html.='<td style=" border-left: none;" class="title">Status</td>';

							
        $_html.='</tr>';
        
        $_noclass = $_count - 1;

        for($i=0; $i<$_count; $i++)
		{

            if(($i%2) == 0)
			{
                $_class = 'odd';
            }else
			{
                $_class = 'even';
            }

				//2016 28th September 09:12:08
				$parsedTime = DateTime::createFromFormat("Y d???F H:i:s" , $_result[$i]['stringValue2']);
				$openedDateTime = $parsedTime->format("jS F Y");
		
                $_html .= '
                <tr>
                	<td style="border-left: none; border-bottom: none;text-align:center;" class="'.$_class.'">#<b>'.$_result[$i]['intValue1'].'</b></td>
					<td style="border-left: none; border-bottom: none; padding-left:20px;" class="'.$_class.'">'.$_result[$i]['stringValue1'].'</td>
					<td style="border-left: none; border-bottom: none;" class="'.$_class.'">'.$openedDateTime.'</td>
					<td style="border-left: none; border-bottom: none;" class="'.$_class.'">'.$_result[$i]['stringValue3'].'</td>';
					if ($displayOrganization) 
						$_html.='<td style="border-right:none; border-bottom: none;text-align:center;padding-left:10px;padding-right:10px;" class="'.$_class.'">'.($_result[$i]['stringValue6']==""?"N/A":$_result[$i]['stringValue6']).'</td>';
							
					$_html.='<td style="border-left: none; border-bottom: none;text-align:center;" class="'.$_class.'">'.secondsToTime($_result[$i]['intValue2'],$showUnits=true).'</td>
					<td style="border-left: none; border-bottom: none;text-align:center;" class="'.$_class.'">'.secondsToTime($_result[$i]['intValue3'],$showUnits=true).'</td>
					<td style="border-left: none; border-bottom: none;text-align:center;" class="'.$_class.'">'.$_result[$i]['intValue4'].'</td>
					<td style="border-left: none; border-bottom: none;text-align:center;padding-left:10px;padding-right:10px;'.getColorByPriority($_result[$i]['stringValue5']).'" class="'.$_class.'">'.($_result[$i]['stringValue5']==""?"N/A":$_result[$i]['stringValue5']).'</td>';
					if ($displayStatus) 
						$_html.='<td style="border-right:none; border-bottom: none;text-align:center;padding-left:10px;padding-right:10px;" class="'.$_class.'">'.$_result[$i]['stringValue4'].'</td>';

               $_html .= '
			   </tr>';
        }
	
        $_html .= '</table>';
		return $_html;
}
function generateTableForProductList($_result, $reportTypeId)
{
	$_html = '
	<table cellpadding="2" cellspacing="1" border="0" style="width: 100%">
	<tr>
		<td style="width: 50%; border-left: none;" class="title">'.(($reportTypeId)==2?"Customer":"Product").'</td>
		<td style=" padding-left: 10px;" class="title">'.(($reportTypeId)==2?"Total Time":"Total").'</td>
	</tr>';
	
	$_noclass = count($_result) - 1;

	for($i=0; $i<count($_result); $i++){
	 
		if(($i%2) == 0){
			$_class = 'odd';
		}else{
			$_class = 'even';
		}
		
		 $value= $_result[$i]['value'];
			$_html .= '
			<tr>
				<td style="border-left: none; border-bottom: none;" class="'.$_class.'">'.$_result[$i]['propertyName'].'</td>
				<td style="padding-left: 10px; border-bottom: none; text-align:center; " class="'.$_class.'">'.(($reportTypeId)==2?secondsToTime($value,true):$value).'</td>
			</tr>
			';
	}

	$_html .= '</table>';
	if(count($_result)==0)
		$_html ="No records found !";

	return $_html;
}

function recalculateWeekFromWeekAndYear ($weekNumber, $yearNumber)
{
	if(!isset($yearNumber))
		$yearNumber= 2016;
	if($yearNumber == 2017)
	{
		return $weekNumber + 52;
	}
	
	if($yearNumber == 2018)
	{
		return $weekNumber + 52 + 52;
	}	
	
	return $weekNumber;
}

function secondsToTime($seconds, $showUnits=false)
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
	if (!$showUnits)
		return  $hours . ":".$minutes.":".$seconds;
	else
	{
	if($hours == 0) return $minutes."m";
		return  $hours . "h ".$minutes."m";
	}
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
function getColorByPriority ($priority)
{
	switch ($priority)
	{
		case "Low":
			return "color:#1AB394;" ;
			break;
		case "Medium":
			return "color:#1c84c6;" ;
			break;
		case "High":
			return "color:orange;";
			break;
		case "Urgent":
			return "color:red;";
			break;
		case "Critical":
			return "color:red;" ;
			break;
	}
	return "color:silver;";
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