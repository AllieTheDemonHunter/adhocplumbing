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

    //Compare
    $compare = $incoming['compare'];
    $title['compare'] = "<b>Comparing:</b> ".$report->makeFriendlyName($compare);

    switch ($incoming['report_type']) {
        case "jobs_per_crew":
            $group = "crew_name";
            switch ($compare) {
                case "actual_job":
                    $jobs[] = new jobs($_POST);
                    $jobs[] = new jobs($_POST);
                    break;
                case "comeback":
                    $jobs[] = new jobs($_POST);
                    $jobs[] = new jobs($_POST);
                    break;
            }
            //Always include all jobs with crew and client filter
            $jobs[] = new jobs($_POST);
            break;
        case "jobs_over_time":
            $group = $incoming['date_granularity'];

            switch ($compare) {
                case "actual_job":
                    $jobs[] = new jobs("Same", $_POST);
                    $jobs[] = new jobs("Different", $_POST);
                    break;
                case "comeback":
                    $jobs[] = new jobs($_POST);
                    $jobs[] = new jobs($_POST);
                    break;
            }
            //Always include all jobs with crew and client filter
            $jobs[] = new jobs("All", $_POST);
            break;
        case "jobs_in_area":
            $group = "province";
            $view = "job_area";
            $jobs[] = new jobs($_POST);
            $jobs[] = new jobs($_POST);
            break;
    }
    if($view == "") {
        $view = "jobs";
    }
    $view = "job_area";
    foreach($jobs as $object) {
        $object->getJobs($view)->formatData();
        $data['values'][] = $object->formatted_data['values'];
        $data['names'] = $object->formatted_data['names'];
    }

    //Crews
    $new_crews = new jobs("crews",$_POST);
    $crews = $new_crews->getJobs();

    //Clients
    $new_clients = new jobs("clients", $_POST);
    $clients = $new_clients->getJobs();

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
        "crews" => $crews->job_values,
        "selected_crew" => $crew,
        "selected_client" => $client,
        "clients" => $clients->job_values,
        "debug" => $jobs));
}