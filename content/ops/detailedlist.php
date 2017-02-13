<?php
$listOfcustomers= array();

$retval = mysql_query( "SELECT *  FROM ".MYSQL_DB.".Customer ", $conn );
while ($row = mysql_fetch_array($retval))
{
	array_push($listOfcustomers,$row);
}
function getColorForPercentage($percent)
{
if($percent <80 )
 return "#BBFFBB";
 if($percent <95 )
 return "#ffff99";
 if($percent >95 )
 return "#FFBBBB";
}
function generateOverviewTable($collection , $conn)
{
 $_html = '';
        for($i=0; $i<count($collection); $i++){
            
            if(($i%2) == 0){
                $_class = 'odd';
            }else{
                $_class = 'even';
            }
			
             $_html .= '
			  <table width ="100%" style="border : 2px solid gray;margin-bottom:10px;">
			 <tr ><td>
			 <table cellpadding="2" cellspacing="1" style="width: 100%; ">
             <tr style="font-color:Black;font-weight:Bold;">
             	<td style="text-align: left;width:10%;padding-left: 10px;  class="'.$_class.'"><a href="index.php?page=ops_migration&CustomerID='.$collection[$i]['CustomerId'].'"><img src="vendor/cet/img/lens.png" /></a> '.$collection[$i]['CustomerName'].'</td>
                <td style="text-align: left;width:30%; padding-left: 10px;  class="'.$_class.'">'.$collection[$i]['CloudDbName'].'</td>
				<td style="text-align: left;width:60%; padding-left: 10px;  class="'.$_class.'">Updated : '.($collection[$i]['Updated']==""?"N/A":$collection[$i]['Updated']).'</td>
		     </tr>
             ';
			$_html .= '</table>';
			$_html .= '</td></tr>';
			$_html .= '<tr><td>';
			
			$_html .= '<table  width="98%" style="margin:4px">';

		
		
		
		
			$retval = mysql_query( "SELECT *  FROM ".MYSQL_DB.".LinkInfo where CustomerId='".$collection[$i]['CustomerId']."' ", $conn );
			
			
			$rowCount = mysql_num_rows($retval);
			if($rowCount>0)
			{
				$_html .= '<tr style="font-size:8px;">';
				$_html .= '<td >Name</td>';
				$_html .= '<td >GUID</td>';
				$_html .= '<td >Updated</td>';
				$_html .= '<td >Low watermark</td>';
				$_html .= '<td >High watermark</td>';
				$_html .= '<td >Free disk space</td>';
				$_html .= '<td >Staging area path</td>';
				$_html .= '<td style="text-align:center;">%</td>';
				// $_html .= '<td>F_EXP</td>';
				// $_html .= '<td>F_IMP</td>';
				// $_html .= '<td>7D_IS</td>';
				// $_html .= '<td>7D_ES</td>';
				// $_html .= '<td>24HES</td>';
				// $_html .= '<td>24HIS</td>';
				// $_html .= '<td>7DIIC</td>';
				// $_html .= '<td>7DEIC</td>';
				// $_html .= '<td>24HIIC</td>';
				// $_html .= '<td>24HEIC</td>';
				$_html .= '</tr>';
			}
			else{$_html .= '<tr style="font-size:8px;"><td>No links synced !</td></tr>';}
			while ($row = mysql_fetch_array($retval))
			{
				$_html .= '<tr style="border:1px solid silver;"><td>'.$row["LinkName"].'</td>';
				$_html .= '<td>'.$row["LinkInfoGuid"].'</td>';
				$_html .= '<td>'.$row["Updated"].'</td>';
				$_html .= '<td>'.formatBytes($row["LowWaterMark"]).'</td>';
				$_html .= '<td>'.formatBytes($row["HighWaterMark"]).'</td>';
				$_html .= '<td>'.formatBytes($row["FreeDiskSpace"]).'</td>';
				$_html .= '<td>'.$row["STGPath"].'</td>';
				$_html .= '<td style="text-align:center;background-color:'.getColorForPercentage($row["percentUsed"]).'">'.$row["percentUsed"].'%</td>';
				
				// $_html .= '<td>'.$row["FailedExported"].'</td>';
				// $_html .= '<td>'.$row["Failedimported"].'</td>';
				// $_html .= '<td>'.formatBytes($row["Last7DImportedSize"]).'</td>';
				// $_html .= '<td>'.formatBytes($row["Last7DExportedSize"]).'</td>';
				// $_html .= '<td>'.formatBytes($row["Last24HExportedSize"]).'</td>';
				// $_html .= '<td>'.formatBytes($row["Last24HImportedSize"]).'</td>';
				// $_html .= '<td>'.$row["Last7DImportedItemCount"].'</td>';
				// $_html .= '<td>'.$row["Last7DExportedItemCount"].'</td>';
				// $_html .= '<td>'.$row["Last24HImportedItemCount"].'</td>';
				// $_html .= '<td>'.$row["Last24HExportedItemCount"].'</td>';
				$_html.='</tr>';
			}
			$_html .= '</table></td></tr>	</table>';		
		}
		$_html .= '
	
		';
		
	return $_html;
}
?>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
          <div class="col-lg-12 ibox-title">
              <h2> OPS overview - all customers </h2>
			  <div class="col-lg-12">
                    <?php echo generateOverviewTable($listOfcustomers,$conn);?>
			  </div>
        

		</div>
	</div>
</div>
