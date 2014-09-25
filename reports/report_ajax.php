<?php
/**
 * Created by PhpStorm.
 * User: allie
 * Date: 2014/09/15
 * Time: 10:36 AM
 */

spl_autoload_register(function ($class) { //Requires > PHP 5.3.0
    include $class . '.class.php';
});

$incoming = $_POST['args'];
if($_POST['action'] == "reports") {
    //Report
    $report = new reports();

    //Type
    $title['report_type'] = "<b>Report Type:</b> ".$report->makeFriendlyName($incoming['report_type']);

    //Date
    $start_date = $incoming['start_date'];
    $end_date = $incoming['end_date'];
    $title['date'] = "<b>Date Range:</b> ".$start_date . " - " . $end_date;

   //Crew
    $crew = $incoming['crew'];
    if($crew != "*") {
        $title['crew'] = "<b>Filtering Crew:</b> ".$crew;
    }

    //Client
    $client = $incoming['client'];
    if($client != "*") {
        $title['client'] = "<b>Filtering Client:</b> ".$client;
    }

    //Province
    $province = $incoming['province'];
    if($province != "*" && $province != "") {
        $title['province'] = "<b>Filtering by Province</b> ";
    }

    //Region
    $region = $incoming['region'];
    if($region != "*" && $region != "") {
        $title['region'] = "<b>Filtering by Region</b> ";
    }

    //Compare
    $compare = $incoming['compare'];
    $title['compare'] = "<b>Comparing:</b> ".$report->makeFriendlyName($compare);

    /**
     * The main entry point into most job questions.
     * Uses chart_config as interface.
     */
    $report_instance = new chart_config($_POST);
    switch ($incoming['report_type']) {
        case "jobs_per_crew":
            $report_instance->group_by = "crew_name";
            break;
        case "jobs_over_time":
            $report_instance->group_by = $incoming['date_granularity'];
            break;
        case "jobs_in_province":
            $report_instance->group_by = "province";
            break;
        case "jobs_in_region":
            $report_instance->group_by = "region";
            break;
        case "jobs_per_job_type":
            $report_instance->group_by = "condition";
            break;
    }
    switch ($compare) {
        case "actual_job":
            $jobs[] = $report_instance->actualJob('same');
            $jobs[] = $report_instance->actualJob('different');
            break;
        case "comeback":
            $jobs[] = $report_instance->comeback("good");
            $jobs[] = $report_instance->comeback("comeback");
            break;
    }

    /**
     * All
     * - Uses $report_instance
     * -- In order to inherit the above contextual filters.
     */
    $jobs[] = $report_instance->all();

    foreach($jobs as $object) {
        $object->getJobs()->formatData();
        $data['values'][] = $object->formatted_data['values'];
        $data['names'] = $object->formatted_data['names']; //names has one extra value at 0 - this is for the graphs.
    }

    /**
     * Running an audit here to remove/exclude entries.
     * which have all their variants at zero.
     *
     * I don't think they're useful and should be omitted.
     */
    // Too lazy to attempt this right now.

    /**
     * Always-applicable filters
     * - These must use all of the filters above.
     */
    $crews = $report_instance->getCrews()->getJobs()->job;
    $clients = $report_instance->getClients()->getJobs()->job;
    $provinces = $report_instance->getProvinces()->getJobs()->job;
    $regions = $report_instance->getRegions()->getJobs()->job;

    foreach($title as $machine_name => $friendly_name) {
        $title_compiled .= '<div id="title-'.$machine_name.'">'.$friendly_name.'</div>';
    }

    $title = '<div class="chart-title">' . $title_compiled . '</div>';

    //Stuff
    $x_label = $report->makeFriendlyName($group);
    $chart_id = "chart-".rand(100, 10000);

    print json_encode(array(
        "title" => $title,
        "x_label" => $x_label,
        "chart_id" => $chart_id,
        "chart_data" => $data,
        "crews" => $crews,
        "selected_crew" => $crew,
        "selected_client" => $client,
        "selected_province" => $province,
        "selected_region" => $region,
        "clients" => $clients,
        "provinces" => $provinces,
        "regions" => $regions,
        "debug-jobs" => $jobs));
}