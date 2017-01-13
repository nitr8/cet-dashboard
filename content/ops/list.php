<?php
$listOfcustomers= array();

$retval = mysql_query( "SELECT distinct c.*,cu.displayed  FROM ".MYSQL_DB.".Customer c  left join CustomersToUser cu on c.CustomerId = cu.customerId  ", $conn );
while ($row = mysql_fetch_array($retval))
{
	array_push($listOfcustomers,$row);
}

function generateTable($collection,$from,$to)
{
 $_html = '  <table cellpadding="2" cellspacing="1" border="0" style="width: 100%">
    	<tr>

            <td style="text-align: center; width: 150px; padding-left: 10px;" class="title">Customer Name</td>
            <td style="text-align: center; width: 200px; padding-left: 10px;" class="title">Cloud Db Name</td>
            <td style="text-align: center; padding-left: 10px;" class="title">Updated</td>
            <td style="text-align: center; width: 50px; padding-left: 10px;" class="title">Enabled (UI)</td>
			<td style="text-align: center; width: 50px; padding-left: 10px;" class="title">Enabled For Sync</td>
        </tr>
        ';

        for($i=$from; $i<$to; $i++){
            
            if(($i%2) == 0){
                $_class = 'odd';
            }else{
                $_class = 'even';
            }
			
                $_html .= '
                <tr>
                	<td style="text-align: left; padding-left: 10px; border-bottom: none;" class="'.$_class.'">'.$collection[$i]['CustomerName'].'</td>
                    <td style="text-align: left; padding-left: 10px; border-bottom: none;" class="'.$_class.'">'.$collection[$i]['CloudDbName'].'</td>
					<td style="text-align: center; padding-left: 10px; border-bottom: none;" class="'.$_class.'">'.($collection[$i]['Updated']==""?"N/A":$collection[$i]['Updated']).'</td>
					<td style="text-align: center; padding-left: 10px; border-bottom: none;" class="'.$_class.'"><input type="checkbox" name="CID'.$collection[$i]['CustomerId'].'" '.(($collection[$i]['displayed']=="1")?"checked":"").'></> </td>
					<td style="text-align: center; padding-left: 10px; border-bottom: none;" class="'.$_class.'"><input disabled="disabled" type="checkbox" name="SyncCID'.$collection[$i]['EnabledForSync'].'" '.(($collection[$i]['EnabledForSync']=="1")?"checked":"").'></> </td>
                </tr>
                ';
        }

        $_html .= '</table>';
	return $_html;
}
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
          <div class="col-lg-12 ibox-title">
              <h2> List of customers for user "<?php echo $userName;?>" </h2>
			  <form action="index.php" method="get">
			  <div class="col-lg-6">
                    <?php echo generateTable($listOfcustomers,0,count($listOfcustomers)/2);?>
			  </div>
			  <div class="col-lg-6">
                    <?php echo generateTable($listOfcustomers,count($listOfcustomers)/2,count($listOfcustomers));?>
			  </div>	

			  <div class="row">	
				<div class="col-lg-12 ibox-title" style="text-align:center">			
					<input type="hidden" name = "page" value = "ops_updating"/>
					<input type="hidden" name = "update" value = "true"/> 
					<input type="submit" value="Save">
					
				</div>           			  
			  </div>           
              </form>
		</div>
	</div>
</div>
