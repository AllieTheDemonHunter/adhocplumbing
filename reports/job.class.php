<?php
/**
 * Created by PhpStorm.
 * User: allie
 * Date: 2014/09/11
 * Time: 7:50 AM
 */



class job extends reports {

    public $start_date;
    public $end_date;
    public $view = 'job_area';
    public $group_by;
    public $order_by;
    public $comeback = NULL; //All job.
    public $service = NULL; //All job.
    public $actual_job = NULL; //All job. TRUE = means it's the same as job card. FALSE = means the job was different.
    public $query;
    public $job = array(); //Array of job objects.
    public $formatted_data;
    public $sql = array();
    public $label = 'data';
    public $master_query;
    public $min_date;
    public $granularity;
    public $job_template;
    public $job_values;
    public $crew;
    public $client;
    public $area = NULL;

    public function __construct($label = NULL, $start_date = NULL, $end_date = NULL, $group_by = NULL, $order_by = NULL, $service = NULL, $comeback = NULL, $actual_job = NULL, $crew = NULL, $client = NULL, $area = NULL) {

        parent::__construct($start_date, $end_date);

        $this->start_date = $start_date;
        $this->end_date = $end_date;

        if($area !== NULL) {
            $this->view = "job_area";
        }

        /**
         * Setting up the label.
         */
        if ($label != NULL) {
            $this->label = $label;
        }

        /**
         * Setting up default/override dates.
         */
        if ($start_date != NULL || $end_date != NULL) {
            $this->start_date = $start_date;
            $this->end_date = $end_date;
        }
        $this->sql['date'] = "AND UNIX_TIMESTAMP(date) BETWEEN UNIX_TIMESTAMP('{$this->start_date}') AND UNIX_TIMESTAMP('{$this->end_date}')";

        /**
         * Setting up filter comeback.
         */
        if ($comeback !== NULL && $comeback !== "*" && $this->comeback === NULL) {
            $this->comeback = $comeback;
            $this->sql['comeback'] = "AND comeback = '". $this->comeback ."'";
        } elseif ($this->comeback !== NULL && $comeback !== "*") {
            $this->sql['comeback'] = "AND comeback = '". $this->comeback ."'";
        }

        /**
         * Setting up filter service.
         */
        if ($service != NULL && $this->service == NULL) {
            $this->service = $service;
            $this->sql['service'] = "AND service = '". $this->service."'";
        }

        /**
         * Setting up filter actual_job.
         */
        if ($actual_job !== NULL && $this->actual_job === NULL) {
            $this->actual_job = $actual_job;
            if ($this->actual_job === TRUE) {
                $this->sql['actual_job'] = "AND actual_job IS NOT NULL";
            } else {
                $this->sql['actual_job'] = "AND actual_job IS NULL";
            }
        }

        /**
         * Setting up filter crew.
         */
        if ($crew !== NULL && $this->crew === NULL) {
            $this->crew = $crew;
        }
        if ($this->crew != "*" && $this->crew === NULL) {
            $this->sql['crew'] = "AND crew_name != '' AND crew_name = '{$crew}'";
        }

        /**
         * Setting up filter client.
         */
        if ($client !== NULL && $this->client === NULL) {
            $this->client = $client;
        }
        if ($this->client != "*" && $this->client !== NULL) {
            $this->sql['client'] = "AND `client_name` != '' AND `client_name` = '{$client}'";
        }

        /**
         * Setting up filter for areas (provinces)
         */
        if ($area['province'] != NULL && $this->area['province'] === NULL) {
            $this->area['province'] = $area['province'];
            $this->view = 'job_area';
        }
        if($this->area['province'] != "*" && $this->area['province'] !== NULL) {
            $this->sql['province'] = "AND `province_id` != '' AND `province_id` = '{$this->area['province']}'";
        }

        /**
         * Setting up default/override GROUP BY.
         */
        if ($group_by != NULL && $this->group_by == NULL) {
            $this->group_by = $group_by;

        } else {
            $this->group_by = 'date';
        }
        $this->granularity = $this->group_by; //Synonyms
        $this->sql['group_by'] = " GROUP BY `{$this->group_by}`";

        /**
         * Setting up default/override ORDER BY.
         */
        if ($order_by !== NULL && $this->order_by === NULL) {
            $this->order_by = $order_by;
        } elseif ($this->order_by === NULL) {
            $this->order_by = 'date';
        }
        $this->sql['order_by'] = "ORDER BY `{$this->order_by}` ASC";

        return $this;
    }

    public function __destruct() {
        parent::__destruct();
    }

    public function getJobs ($view = NULL) {
        if($view !== NULL) {
            $this->view = $view;
        }
        $this->query = "SELECT `date`,
                  `crew_name`,
                  COUNT(*) AS `count`,
                  `year`,
                  `week_of_year`,
                  `month`,
                  `year_month`,
                  `month_day`,
                  `client_name`,
                  `province`
                FROM {$this->view}
                WHERE 1";

        $this->master_query = "SELECT `date`, `crew_name`, `year`, `week_of_year`, `month`, `year_month`, `month_day`, `client_name`, '0' AS `count`, `province` AS `province` FROM `{$this->view}` WHERE 1 " . " " . $this->sql['date']. " " .$this->sql['group_by']. " " .$this->sql['order_by'];
        foreach ($this->sql as $directive) {
            $this->query .= " ".$directive;
        }

        $year = void;
        $week_of_year = void;
        $month = void;
        $year_month = void;
        $month_day = void;
        $client_name = void;
        $count = void;

        if ($stmt = $this->dbcon->prepare($this->master_query)) {
            $stmt->execute();
            $stmt->bind_result($date, $crew_name, $year, $week_of_year, $month, $year_month, $month_day, $client_name, $count, $province);

            while ($stmt->fetch()) {
                $r = new stdClass();
                $key_name = $this->group_by;
                $key = $$key_name;
                $r->$key_name = $key;
                $r->count = '0';
                $this->job_template[$key] = $r;
            }
            $stmt->close();
        }

        if ($stmt = $this->dbcon->prepare($this->query)) {
            $stmt->execute();
            $stmt->bind_result($date, $crew_name,  $count, $year, $week_of_year, $month, $year_month, $month_day, $client_name, $province);
            while ($stmt->fetch()) {
                $key_name = $this->group_by;
                $key = $$key_name;
                $this->job_values[$key] = new job(array('date' => $date, 'crew_name' => $crew_name,  'count' => $count, 'year' => $year, 'week_of_year' => $week_of_year, 'month' => $month, 'year_month' => $year_month, 'month_day' => $month_day, 'client_name' => $client_name));
            }
            $stmt->close();
        }
        $this->dbcon->close();
        foreach($this->job_template as $template_key => $template_value) {
            if($this->job_values[$template_key]) {
                $this->job[$template_key] = $this->job_values[$template_key];
            } else {
                $this->job[$template_key] = $template_value;
            }
        }
        return $this;
    }

    public function formatData() {
        $this->formatted_data['names'] = array_keys($this->job);
        $this->formatted_data['values'][] = $this->label;
        foreach($this->job as $job_group) {
            $this->formatted_data['values'][] = $job_group->count;
        }
        return $this;
    }

}