<?php
class Database{

	// debug flag for showing error messages
	public	$debug = true;

	// Store the single instance of Database
	private static $instance;

	private	$server   = ""; //database server
	private	$user     = ""; //database login name
	private	$pass     = ""; //database login password
	private	$database = ""; //database name

	private	$error = "";

	#######################
	//number of rows affected by SQL query
	public	$affected_rows = 0;

	private	$link_id = 0;
	private	$query_id = 0;

private function __construct($server=null, $user=null, $pass=null, $database=null){
	// error catching if not passed in
	if($server==null || $user==null || $database==null){
		$this->oops("Database information must be passed in when the object is first created.");
	}

	$this->server=$server;
	$this->user=$user;
	$this->pass=$pass;
	$this->database=$database;
}
public static function obtain($server=null, $user=null, $pass=null, $database=null){
	if (!self::$instance){ 
		self::$instance = new Database($server, $user, $pass, $database); 
	} 

	return self::$instance; 
}
public function connect($new_link=false){
	$this->link_id=@mysql_connect($this->server,$this->user,$this->pass,$new_link);

	if (!$this->link_id){//open failed
		$this->oops("Could not connect to server: <b>$this->server</b>.");
		}

	if(!@mysql_select_db($this->database, $this->link_id)){//no database
		$this->oops("Could not open database: <b>$this->database</b>.");
		}

	// unset the data so it can't be dumped
	$this->server='';
	$this->user='';
	$this->pass='';
	$this->database='';
}
public function close(){
	if(!@mysql_close($this->link_id)){
		$this->oops("Connection close failed.");
	}
}
public function escape($string){
	if(get_magic_quotes_runtime()) $string = stripslashes($string);
	return @mysql_real_escape_string($string,$this->link_id);
}
public function query($sql){
	// do query
	$this->query_id = @mysql_query($sql, $this->link_id);

	if (!$this->query_id){
		$this->oops("<b>MySQL Query fail:</b> $sql");
		return 0;
	}
	
	$this->affected_rows = @mysql_affected_rows($this->link_id);

	return $this->query_id;
}
public function getTicketCountforStatus($ticketStatus,$departmentTitle)
{    
    $_row = $this->query_first("select count(*) as cnt from ".KSQL_TPRFX."tickets where ".KSQL_TPRFX."tickets.ticketstatustitle ='".$ticketStatus."' and departmenttitle='".$departmentTitle."'");
    if( empty($_row) ){
    
        echo "No custom fields found. Please contact Administrator.";
        exit;
    }
return $_row['cnt']; 
}

public function query_first($query_string){
	$query_id = $this->query($query_string);
	$out = $this->fetch($query_id);
	$this->free_result($query_id);
	return $out;
}
public function fetch($query_id=-1){
	// retrieve row
	if ($query_id!=-1){
		$this->query_id=$query_id;
	}

	if (isset($this->query_id)){
		$record = @mysql_fetch_assoc($this->query_id);
	}else{
		$this->oops("Invalid query_id: <b>$this->query_id</b>. Records could not be fetched.");
	}

	return $record;
}
public function fetch_array($sql){
	$query_id = $this->query($sql);
	$out = array();

	while ($row = $this->fetch($query_id)){
		$out[] = $row;
	}

	$this->free_result($query_id);
	return $out;
}
public function update($table, $data, $where='1'){
	$q="UPDATE `$table` SET ";

	foreach($data as $key=>$val){
		if(strtolower($val)=='null') $q.= "`$key` = NULL, ";
		elseif(strtolower($val)=='now()') $q.= "`$key` = NOW(), ";
        elseif(preg_match("/^increment\((\-?\d+)\)$/i",$val,$m)) $q.= "`$key` = `$key` + $m[1], "; 
		else $q.= "`$key`='".$this->escape($val)."', ";
	}

	$q = rtrim($q, ', ') . ' WHERE '.$where.';';

	return $this->query($q);
}
public function insert($table, $data){
	$q="INSERT INTO `$table` ";
	$v=''; $n='';

	foreach($data as $key=>$val){
		$n.="`$key`, ";
		if(strtolower($val)=='null') $v.="NULL, ";
		elseif(strtolower($val)=='now()') $v.="NOW(), ";
		else $v.= "'".$this->escape($val)."', ";
	}

	$q .= "(". rtrim($n, ', ') .") VALUES (". rtrim($v, ', ') .");";

	if($this->query($q)){
		return mysql_insert_id($this->link_id);
	}
	else return false;

}#-#insert()


#-#############################################
# desc: frees the resultset
# param: query_id for mysql run. if none specified, last used
private function free_result($query_id=-1){
	if ($query_id!=-1){
		$this->query_id=$query_id;
	}
	if($this->query_id!=0 && !@mysql_free_result($this->query_id)){
		$this->oops("Result ID: <b>$this->query_id</b> could not be freed.");
	}
}#-#free_result()


#-#############################################
# desc: throw an error message
# param: [optional] any custom error to display
private function oops($msg=''){
	if(!empty($this->link_id)){
		$this->error = mysql_error($this->link_id);
	}
	else{
		$this->error = mysql_error();
		$msg="<b>WARNING:</b> No link_id found. Likely not be connected to database.<br />$msg";
	}

	// if no debug, done here
	if(!$this->debug) return;
	?>
		<table align="center" border="1" cellspacing="0" style="background:white;color:black;width:80%;">
		<tr><th colspan=2>Database Error</th></tr>
		<tr><td align="right" valign="top">Message:</td><td><?php echo $msg; ?></td></tr>
		<?php if(!empty($this->error)) echo '<tr><td align="right" valign="top" nowrap>MySQL Error:</td><td>'.$this->error.'</td></tr>'; ?>
		<tr><td align="right">Date:</td><td><?php echo date("l, F j, Y \a\\t g:i:s A"); ?></td></tr>
		<?php if(!empty($_SERVER['REQUEST_URI'])) echo '<tr><td align="right">Script:</td><td><a href="'.$_SERVER['REQUEST_URI'].'">'.$_SERVER['REQUEST_URI'].'</a></td></tr>'; ?>
		<?php if(!empty($_SERVER['HTTP_REFERER'])) echo '<tr><td align="right">Referer:</td><td><a href="'.$_SERVER['HTTP_REFERER'].'">'.$_SERVER['HTTP_REFERER'].'</a></td></tr>'; ?>
		</table>
	<?php
}


}
?>