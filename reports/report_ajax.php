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
    $province_id = $incoming['province'];
    if($province_id != "*" && $province_id != "") {
        $title['province'] = "<b>Filtering by Province</b> ";
        $area['province'] = $province_id;
    }

    //Compare
    $compare = $incoming['compare'];
    $title['compare'] = "<b>Comparing:</b> ".$report->makeFriendlyName($compare);

    switch ($incoming['report_type']) {
        case "jobs_per_crew":
            $group = "crew_name";
            switch ($compare) {
                case "actual_job":
                    $jobs[] = new job('Same', $start_date, $end_date, $group, NULL, NULL, NULL, TRUE, $crew, $client, $area);
                    $jobs[] = new job('Different', $start_date, $end_date, $group, NULL, NULL, NULL, FALSE, $crew, $client, $area);
                    break;
                case "comeback":
                    $jobs[] = new job('Comebacks', $start_date, $end_date, $group, NULL, NULL, 'comeback', NULL, $crew, $client, $area);
                    $jobs[] = new job('Good Jobs', $start_date, $end_date, $group, NULL, NULL, 'good', NULL, $crew, $client, $area);
                    break;
            }
            //Always include all job with crew and client filter
            $jobs[] = new job('All Jobs', $start_date, $end_date, $group, NULL, NULL, NULL, NULL, $crew, $client, $area);
            break;
        case "jobs_over_time":
            $group = $incoming['date_granularity'];

            switch ($compare) {
                case "actual_job":
                    $jobs[] = new job('Same', $start_date, $end_date, $group, NULL, NULL, NULL, TRUE, $crew, $client, $area);
                    $jobs[] = new job('Different', $start_date, $end_date, $group, NULL, NULL, NULL, FALSE, $crew, $client, $area);
                    break;
                case "comeback":
                    $jobs[] = new job('Comebacks', $start_date, $end_date, $group, NULL, NULL, 'comeback', NULL, $crew, $client, $area);
                    $jobs[] = new job('Good Jobs', $start_date, $end_date, $group, NULL, NULL, 'good', NULL, $crew, $client, $area);
                    break;
            }
            //Always include all job with crew and client filter
            $jobs[] = new job('All Jobs', $start_date, $end_date, $group, NULL, NULL, NULL, NULL, $crew, $client, $area);
            break;
        case "jobs_in_area":
            $group = "province";
            $view = "job_area";
            $jobs[] = new job('All Jobs', $start_date, $end_date, $group, NULL, NULL, NULL, NULL, $crew, $client, NULL);
            $jobs[] = new job('Province', $start_date, $end_date, $group, NULL, NULL, NULL, NULL, $crew, $client, $area);
            break;
    }
    if($view == "") {
        $view = "job";
    }
    $view = "job_area";
    foreach($jobs as $object) {
        $object->getJobs($view)->formatData();
        $data['values'][] = $object->formatted_data['values'];
        $data['names'] = $object->formatted_data['names'];
        unset($object);
    }

    unset($jobs);

    //Crews
    $new_crews = new job('All Jobs', $start_date, $end_date, 'crew_name', NULL, NULL, NULL, NULL, $crew, $client);
    $crews = $new_crews->getJobs();
    unset($new_crews);

    //Clients
    $new_clients = new job('All Jobs', $start_date, $end_date, 'client_name', NULL, NULL, NULL, NULL, $crew, $client);
    $clients = $new_clients->getJobs();
    unset($new_clients);
    sleep(1);

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
        "job" => $data,
        "crews" => $crews->jobs,
        "selected_crew" => $crew,
        "selected_client" => $client,
        "clients" => $clients->jobs,
        "debug" => $jobs));
}