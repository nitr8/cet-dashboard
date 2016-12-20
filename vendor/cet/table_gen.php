<?php 

function generateBox($db,$title,$sqlQuery,$columnAliases,$columnNames,$displaycount,$heigthinPx=0,$displayTools= true,$Hsize=5,$limit=5) 
{
    $_result = array();
    $_count = 0;
    $_noclass = 0;
    $_class = '';
	$_html="";
    //first we get total count 
	$_row = $db->query_first("SELECT count(*) as cnt from (".$sqlQuery.")a");

	$_totalCount= $_row['cnt'];
	
	
    $rows = $db->query($sqlQuery );
    while ($record = $db->fetch($rows))
     {
         $_result[] = $record;
     }
    
    $_count = count($_result);
    $_noclass = $_count - 1;	
    $displaycnt="";
    if($displaycount)
	{
	if ($limit > $_totalCount)
		{
        $displaycnt = "(".$_count.")";
		}
		else
		{
			$displaycnt = "(Displayed ".$limit." from <span style=\"color:maroon\">".$_totalCount."</span>)";
		}
	}

    echo ("<div class=\"ibox float-e-margins\">");
    echo ("		<div class=\"ibox-title\">");
    echo ("			<h".$Hsize.">".$title." <span style=\"color:silver;font-size:12px;\">".$displaycnt."</span></h".$Hsize.">");
	if($displayTools){
    echo ("			<div class=\"ibox-tools\">");
    echo ("				<a class=\"collapse-link\">");
    echo ("					<i class=\"fa fa-chevron-up\"></i>");
    echo ("				</a>");
    echo ("			</div>");}
    echo ("		</div>");
    echo ("<div class=\"ibox-content\" ");
	if ($heigthinPx != 0) 
		echo ("style=\"height:".$heigthinPx."px\"");
		
	echo (">");
     if($_count==0)
	 {
	 $_html .="<h2>No tickets !</h2>";
	 }
	 else
	 
	 {
    $_html = '<table cellpadding="2" cellspacing="1" border="0" style="width: 100%"><tr>';
    for($j=0; $j<count($columnNames); $j++)
    {
    	if($j==0)
    		$_html .='<td style="width: 50px; border-left: none;" class="title">'.$columnNames[$j].'</td>';
    	else
        if($columnNames[$j]=="Owner")
            $_html .='<td style="width: 100px;" class="title">'.$columnNames[$j].'</td>';
            else
    		$_html .='<td  class="title">'.$columnNames[$j].'</td>';
    }
    $_html .='</tr>';
    
    for($i=0; $i<$_count; $i++)
    {
		if($i>=$limit) break;
        if(($i%2) == 0)
    	{
            $_class = 'odd';
        }else
    	{
            $_class = 'even';
        }
        
        //if($i == $_noclass)
    	
         $_html .= '<tr>';
    	 for($j=0; $j<count($columnNames); $j++)
    	 {
    		if($j==0)
    			$_html .= '<td style="width: 50px; border-left: none; border-bottom: none;" class="'.$_class.'">#'.$_result[$i][$columnAliases[$j]].'</td>';
    		else
             if($columnNames[$j]=="Owner" && $_result[$i][$columnAliases[$j]]=="")
                $_html .= '<td style="border-bottom: none; color:red" class="'.$_class.'">Unassigned</td>';
             else  
			 switch ($columnNames[$j])
			 {
				case "Type":
				{
					switch	($_result[$i][$columnAliases[$j]])
					{
						case "Enhancement":
							$_html .= '<td style="border-bottom: none;text-align:center;"= class="'.$_class.'"><img src="vendor/cet/img/enhacement.png" alt="Enhacement" /></td>';
						break;
						case "Bug":
							$_html .= '<td style="border-bottom: none;text-align:center;" class="'.$_class.'"><img src="vendor/cet/img/bug.png" alt="Bug"/></td>';
						break;
						case "Issue":
							$_html .= '<td style="border-bottom: none;text-align:center;" class="'.$_class.'"><img src="vendor/cet/img/issue.png" alt="Issue" /></td>';
						break;
						case ".cloud":
							$_html .= '<td style="border-bottom: none;text-align:center;" class="'.$_class.'"><img src="vendor/cet/img/cloud.png" alt="cloud"/></td>';
						break;	
						case "Question":
							$_html .= '<td style="border-bottom: none;text-align:center;" class="'.$_class.'"><img src="vendor/cet/img/question.png" alt="question"/></td>';
						break;	
						case "Not Set":
							$_html .= '<td style="border-bottom: none;text-align:center;" class="'.$_class.'"><img src="vendor/cet/img/notset.png" alt="notset"/></td>';
						break;	
						case "Action":
							$_html .= '<td style="border-bottom: none;text-align:center;" class="'.$_class.'"><img src="vendor/cet/img/action.png" alt="Action" /></td>';
						break;						
					default:
							$_html .= '<td style="border-bottom: none;text-align:center;" class="'.$_class.'">'.$_result[$i][$columnAliases[$j]].'</td>';
						break;							
					}
					break;
				}
				case "Resolution Date":
				{
					$_html .= '<td style="border-bottom: none;text-align:center;" class="'.$_class.'">'.$_result[$i][$columnAliases[$j]].'</td>';
					break;
				}
				case "Time Spent":
				{

					$_html .= '<td style="border-bottom: none;text-align:center;" class="'.$_class.'">'.secondsToTime($_result[$i][$columnAliases[$j]]).'</td>';
					break;
				}
				case "Priority" :
					switch	($_result[$i][$columnAliases[$j]])
					{
						case "Low":
							$_html .= '<td style="border-bottom: none;text-align:center;color:#1AB394;" class="'.$_class.'">'.$_result[$i][$columnAliases[$j]].'</td>';
							break;
						case "Medium":
							$_html .= '<td style="border-bottom: none;text-align:center;color:#1c84c6;" class="'.$_class.'">'.$_result[$i][$columnAliases[$j]].'</td>';
							break;
						case "High":
							$_html .= '<td style="border-bottom: none;text-align:center;color:orange;" class="'.$_class.'">'.$_result[$i][$columnAliases[$j]].'</td>';
							break;
						case "Urgent":
							$_html .= '<td style="border-bottom: none;text-align:center;color:red;" class="'.$_class.'">'.$_result[$i][$columnAliases[$j]].'</td>';
							break;
						case "Critical":
							$_html .= '<td style="border-bottom: none;text-align:center;color:red;" class="'.$_class.'">'.$_result[$i][$columnAliases[$j]].'</td>';
							break;

					}
					break;
				default : 
					$_html .= '<td style="border-bottom: none;" class="'.$_class.'">'.$_result[$i][$columnAliases[$j]].'</td>';
					break;
				}
				
			
    	 }
        $_html .= '</tr>';
    
    }

    $_html .= '</table>';
	}
	    $_html .= '</div> </div>';
    
    echo $_html;
    unset($_result);
    unset($_count);
    unset($_html);
    unset($_noclass);	
}

?>