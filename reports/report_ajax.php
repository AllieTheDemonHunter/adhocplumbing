<?php
/**
 * Created by PhpStorm.
 * User: allie
 * Date: 2014/09/15
 * Time: 10:36 AM
 */

require_once 'jobs.php';
$incoming = $_POST['args'];
if($_POST['action'] == "report") {
    //Report
    $report = new report();

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

    //Compare
    $compare = $incoming['compare'];
    $title['compare'] = "<b>Comparing:</b> ".$report->makeFriendlyName($compare);

    switch ($incoming['report_type']) {
        case "jobs_per_crew":
            $group = "crew_name";
            switch ($compare) {
                case "actual_job":
                    $jobs[] = new jobs('Same', $start_date, $end_date, $group, NULL, NULL, NULL, TRUE, $crew, $client);
                    $jobs[] = new jobs('Different', $start_date, $end_date, $group, NULL, NULL, NULL, FALSE, $crew, $client);
                    break;
                case "comeback":
                    $jobs[] = new jobs('Comebacks', $start_date, $end_date, $group, NULL, NULL, 'comeback', NULL, $crew, $client);
                    $jobs[] = new jobs('Good Jobs', $start_date, $end_date, $group, NULL, NULL, 'good', NULL, $crew, $client);
                    break;
            }
            break;
        case "jobs_over_time":
            $group = $incoming['date_granularity'];

            switch ($compare) {
                case "actual_job":
                    $jobs[] = new jobs('Same', $start_date, $end_date, $group, NULL, NULL, NULL, TRUE, $crew, $client);
                    $jobs[] = new jobs('Different', $start_date, $end_date, $group, NULL, NULL, NULL, FALSE, $crew, $client);
                    break;
                case "comeback":
                    $jobs[] = new jobs('Comebacks', $start_date, $end_date, $group, NULL, NULL, 'comeback', NULL, $crew, $client);
                    $jobs[] = new jobs('Good Jobs', $start_date, $end_date, $group, NULL, NULL, 'good', NULL, $crew, $client);
                    break;
            }
            break;
        case "jobs_in_area":

            break;
    }
    //Always include all jobs with crew and client filter
    $jobs[] = new jobs('All Jobs', $start_date, $end_date, $group, NULL, NULL, NULL, NULL, $crew, $client);

    foreach($jobs as $object) {
        $object->getJobs()->formatData();
        $data['values'][] = $object->formatted_data['values'];
        $data['names'] = $object->formatted_data['names'];
    }

    //Crews
    $new_crews = new jobs('All Jobs', $start_date, $end_date, 'crew_name', NULL, NULL, NULL, NULL, $crew, $client);
    $crews = $new_crews->getJobs();

    //Clients
    $new_clients = new jobs('All Jobs', $start_date, $end_date, 'client_name', NULL, NULL, NULL, NULL, $crew, $client);
    $clients = $new_clients->getJobs();

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
        "jobs" => $data,
        "crews" => $crews->jobs,
        "selected_crew" => $crew,
        "selected_client" => $client,
        "clients" => $clients->jobs));
}