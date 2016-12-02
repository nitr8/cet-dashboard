<div class="wrapper wrapper-content">
<?php
	
generateReportWithCharts(TICKETS_PER_PRODUCT);
generateReportWithCharts(NEW_ISSUES_PER_PRODUCT);

generateTableReport(URGENT_CASES);
generateTableReport(SLA_BROKEN);
generateTableReport(AGED_CASES);
generateTableReport(CLOSED_CASES,$displayStatus = false);

generateReportWithCharts(MANAGED_MIGRATIONS);
generateReportWithCharts(TOP_TEN_TIME_TAKERS);

generateReportWithCharts(QFE_FIXES_PER_PRODUCT);
generateTableReport(QFE_CLOSED,$displayStatus = false);

?>
</div>