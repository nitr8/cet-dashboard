<?php 
require_once ("vendor/cet/helper/reporthelper.php");
?>
<div class="wrapper wrapper-content">
<?php
	
generateReportWithCharts(TICKETS_PER_PRODUCT);
generateReportWithCharts(NEW_ISSUES_PER_PRODUCT);
generateReportWithCharts(MANAGED_MIGRATIONS);
generateReportWithCharts(QFE_FIXES_PER_PRODUCT);

generateTableReport(AGED_CASES);
generateTableReport(CLOSED_CASES) ;
generateTableReport(QFE_CLOSED);
generateTableReport(SLA_BROKEN);
generateTableReport(URGENT_CASES);

?>
</div>