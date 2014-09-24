<?php
/**
 * Created by PhpStorm.
 * User: allie
 * Date: 2014/09/11
 * Time: 7:50 AM
 */

class jobs extends reports {

    public $start_date;
    public $end_date;
    public $view = 'job_area';
    public $group_by;
    public $order_by;
    public $comeback = NULL; //All jobs.
    public $service = NULL; //All jobs.
    public $actual_job = NULL; //All jobs. TRUE = means it's the same as jobs card. FALSE = means the jobs was different.
    public $query;
    public $job = array(); //Array of jobs objects.
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

    public function __construct($label = NULL, $args) {
        foreach ($args as $arg => $val) {
            $this->$arg = $val;
        }

        parent::__construct($args->start_date, $args->end_date);

        /**
         * Setting up the label.
         */
        if($this->label == "" && $label !== NULL) {
            $this->label = $label;
        }

        /**
         * Always applicable.
         */
        $this->sql['date'] = "AND UNIX_TIMESTAMP(date) BETWEEN UNIX_TIMESTAMP('{$this->start_date}') AND UNIX_TIMESTAMP('{$this->end_date}')";

        /**
         * Setting up filter comeback.
         */
        if ($this->comeback !== "*" && $this->comeback !== NULL) {
            $this->sql['comeback'] = "AND comeback = '". $this->comeback ."'";
        }

        /**
         * Setting up filter service.
         */
        if ($this->service != "*" && $this->service !== NULL) {
            $this->sql['service'] = "AND service = '". $this->service."'";
        }

        /**
         * Setting up filter actual_job.
         */
        if ($this->actual_job != "*") {
            if ($this->actual_job === "same") {
                $this->sql['actual_job'] = "AND actual_job IS NOT NULL";
            } elseif($this->actual_job === "different") {
                $this->sql['actual_job'] = "AND actual_job IS NULL";
            }
        }

        /**
         * Setting up filter crew.
         */
        if ($this->crew != "*" && $this->crew != NULL) {
            $this->sql['crew'] = "AND crew_name != '' AND crew_name = '{$this->crew}'";
        }

        /**
         * Setting up filter client.
         */
        if ($this->client != "*" && $this->client !== NULL) {
            $this->sql['client'] = "AND `client_name` != '' AND `client_name` = '{$this->client}'";
        }

        /**
         * Setting up filter for provinces
         */
        if($this->province != "*" && $this->province !== NULL) {
            $this->sql['province'] = "AND `province_id` != '' AND `province_id` = '{$this->province}'";
        }

        /**
         * Setting up default/override GROUP BY.
         */
        $this->granularity = $this->group_by; //Synonyms
        $this->sql['group_by'] = " GROUP BY `{$this->group_by}`";

        /**
         * Setting up default/override ORDER BY.
         */
        if ($this->order_by == '') {
            $this->order_by = 'date';
        }
        $this->sql['order_by'] = "ORDER BY `{$this->order_by}` ASC";

        return $this;
    }

    public function __destruct() {
        parent::__destruct();
    }

    public function getJobs () {
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

        if ($result = $this->dbcon->query($this->master_query)) {
            while($template_row = $result->fetch_object()) {
                $key_name = $this->group_by;
                $key = $template_row->$key_name;
                $this->job_template[$key] = $template_row;
            }
        }

        if ($result = $this->dbcon->query($this->query)) {
            while($result_row = $result->fetch_object()) {
                $key_name = $this->group_by;
                $key = $result_row->$key_name;
                $this->job_values[$key] = $result_row;
            }

        }

        if(is_array($this->job_template) && count($this->job_template) > 0) {
            $this->job = new job();

            foreach($this->job_template as $template_key => $template_value) {
                if($this->job_values[$template_key]) {
                    $this->job->$template_key = $this->job_values[$template_key];
                } else {
                    $this->job->$template_key = $template_value;
                }
            }
        }
        return $this;
    }

    public function formatData() {
        if(isset($this->job->count)) {
            unset($this->job->count);
        }
        $this->formatted_data['names'] = array_keys(get_object_vars($this->job));
        $this->formatted_data['values'][] = $this->label;
        if(is_object($this->job)) {
            foreach($this->job as $job_group) {
                $this->formatted_data['values'][] = $job_group->count;
            }
            return $this;
        }
    }

}