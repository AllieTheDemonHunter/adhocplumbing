<?php
if ($_COOKIE['MM_UserGroup'] < 5) {
	$deniedGoTo = "index.php";
//	header(sprintf("Location: %s", $deniedGoTo));
}
require_once('inc_before.php');

spl_autoload_register(function ($class) { //Requires > PHP 5.3.0
    include 'reports/' . $class . '.class.php';
});

$report = new reports();

?>

<link href="reports/reports.css" rel="stylesheet" type="text/css">

<!-- Load c3.css -->
<link href="/vendor/bower_components/c3/c3.css" rel="stylesheet" type="text/css">

<!-- Load d3.js and c3.js -->
<script src="/vendor/bower_components/d3/d3.js" charset="utf-8" type="text/javascript"></script>
<script src="/vendor/bower_components/c3/c3.js" type="text/javascript"></script>

<script src="/vendor/bower_components/jquery/dist/jquery.min.js" type="text/javascript"></script>
<script src="/vendor/bower_components/jqueryui/jquery-ui.min.js" type="text/javascript"></script>

<script src="/vendor/bower_components/tidy-table/jquery.tidy.table.min.js" type="text/javascript"></script>

<link href="/vendor/bower_components/jqueryui/themes/ui-lightness/jquery-ui.min.css" rel="stylesheet" type="text/css">
<link href="/vendor/bower_components/tidy-table/jquery.tidy.table.min.css" rel="stylesheet" type="text/css">

<script src="reports/jobs_vs_comebacks.js" type="text/javascript"></script>
<h3 id="chart-heading">Reports:</h3>
<div id="criteria">
    <svg version="1.1"
         xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
         x="0px" y="0px" width="480px" viewBox="0 0 480 340"  xml:space="preserve" id="loader">
    <defs>
        <clipPath id="mask">
            <polygon transform="rotate(180 18 11)" points="10,15.2 13.5,10.9 23.2,20.8 35.7,7.9 35.7,0 10,0 "/>
        </clipPath>
    </defs>

        <g transform= "rotate(180 18 11)" clip-path="url(#mask)">
            <rect x="0" y="0" width="7" height="14" fill="#f2f2f2">
                <animateTransform  attributeType="xml"
                                   attributeName="transform" type="scale"
                                   values="1,1; 1,1.5; 1,1"
                                   begin="0.4s" dur="0.8s" repeatCount="indefinite" />
            </rect>
            <rect x="9" y="0" width="7" height="19" fill="#f2f2f2">
                <animateTransform  attributeType="xml"
                                   attributeName="transform" type="scale"
                                   values="1,0.2; 1,1.2; 1,0.2"
                                   begin="0.3s" dur="0.8s" repeatCount="indefinite" />
            </rect>
            <rect x="18" y="0" width="8" height="14" fill="#f2f2f2">
                <animateTransform  attributeType="xml"
                                   attributeName="transform" type="scale"
                                   values="1,0.2; 1,1.5; 1,0.2"
                                   begin="0s" dur="0.8s" repeatCount="indefinite" />
            </rect>
        </g>

        <polygon fill="#1FA2D0" points="38.6,2 41.4,4.2 36.1,10.2 29.5,17 26.8,19.8 23.3,23.3 19.9,19.8 17.1,17 13.7,13.5 10.2,17.7 0,30.2 10,20.8 10,34 16.9,34 16.9,22.2 19.7,25.1 19.7,34 26.7,34 26.7,25.3 29.5,22.5 29.5,34 36.4,34 36.4,15.5 44.1,7.1
    46.4,9.7 48,0   "/>

</svg>
    <div class="criteria-select" id="from-select">
        <label for="from" class="date-label">From</label>
        <input type="text" id="from" name="from"  class="date-input" placeholder="Click to select a From date.">
    </div>
    <div class="criteria-select" id="to-select">
        <label for="to" class="date-label">To</label>
        <input type="text" id="to" name="to"  class="date-input" placeholder="Click to select a To date.">
    </div>
    <?php
    print $report->report_type_select_html;
    print $report->date_granularity_select_html;
    print $report->chart_types_select_html;
    print $report->compare_types_select_html;

    $report->dbcon->close(); unset($report);

    $crews = new crews();
    print $crews->getCrews()->buildSelect();

    $clients = new clients();
    print $clients->getClients()->buildSelect();

    $areas = new areas();
    print $areas->buildSelect($areas->getAreas("provinces")->provinces, "Provinces", NULL, TRUE);
    print $areas->buildSelect($areas->getAreas("regions")->regions, "Regions", NULL, TRUE);
    print $areas->buildSelect($areas->getAreas("suburbs")->suburbs, "Suburbs", NULL, TRUE);
    ?>
</div>
<script type="text/javascript">
    $(document).ready(function() {


    });
</script>
<div id="container1"></div>
<div id="container"></div>
<br /><br /><br />
<?php require_once('inc_after.php'); ?>

</body>
</html>
