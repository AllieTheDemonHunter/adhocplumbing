<?php
/**
 * Created by PhpStorm.
 * User: allie
 * Date: 2014/09/11
 * Time: 7:50 AM
 */

class report {
    protected $dbcon;
    private $hostname = 'localhost';
    private $username = 'root';
    private $password = 'ekiswit';
    private $database = 'adhoc_adhocpanmv_db2';
    public $min_date;
    protected $date_granularity;
    public $date_granularity_select_html;
    protected $chart_types;
    public $chart_types_select_html;
    public $report_types;
    public $report_type_select_html;
    protected $compare_types;
    public $compare_types_select_html;
    public $province_id;

    public function __construct($start_date = NULL, $end_date = NULL) {
        $this->dbcon = mysqli_connect($this->hostname, $this->username, $this->password, $this->database);
        $this->date_granularity_select_html = $this->buildSelect($this->getDateGranularity()->date_granularity, "Date Granularity");
        $this->chart_types_select_html = $this->buildSelect($this->getChartTypes()->chart_types, "Chart Types");
        $this->getReportTypes();
        $this->getCompareTypes();
        return $this;
    }

    public function formatData ($data, $return = 'names') {
        $names_pieces = "";
        $values_pieces = "";
        foreach ($data as $key => $row) {
            $group_by = $this->group_by;
            $names_pieces .= "'".$key."', ";
            $values_pieces .= $row->count.", ";
        }

        $names = "[".substr($names_pieces,0,-2)."]";
        $values = "['".$this->label."',".substr($values_pieces,0,-2)."]";
        return $$return;
    }

    public function print_a ($data) {
        print "<pre style='font-family: courier; font-size: 10px;'>".print_r($data,1)."</pre>";
        //print "<script>console.log('".json_encode($data).");</script>";
    }

    public function makeMachineName ($friendly_name) {
        return strtolower(str_replace(" ", "_", $friendly_name));
    }

    public function makeFriendlyName ($machine_name) {
        return ucwords(str_replace("_", " ", $machine_name));
    }

    public function buildSelect ($data, $friendly_name, $machine_name = NULL, $no_key_override = FALSE) {
        if ($machine_name == NULL) {
            $machine_name = $this->makeMachineName($friendly_name);
        }

        if (is_array($data) && count($data) > 0) {
            $elements = '';
            foreach ($data as $key => $value) {
                if(!$no_key_override) {
                    $override_value = is_string($key) ? $key : $value;
                } else {
                    $override_value = $key;
                }
                $elements .= "<option value='$override_value'>{$value}</option>";
            }
            return "<div class='criteria-select' id='{$machine_name}'><label for='$machine_name'>{$friendly_name}</label><select name='{$machine_name}'>{$elements}</select></div>";
        } else {
            return FALSE;
        }
    }

    /**
     * Get minimum date. The first date in the table.
     */
    public function getMinDate () {
        //Using the predefined view.
        $sql = "SELECT MIN(date) AS min_date FROM jobs";
        if ($stmt = $this->dbcon->prepare($sql)) {
            $stmt->execute();
            $stmt->bind_result($this->min_date);
            $stmt->fetch();
            $stmt->close();
            return $this;
        }
    }

    public function getDateGranularity() {
        $this->date_granularity = array(
            'month_day' => 'Days per Month',
            'week_of_year' => 'Week of Year',
            'year' => 'Year',
            'year_month' => 'Months of Year'
        );
        return $this;
    }

    public function getChartTypes() {
        $this->chart_types = array(
            'spline' => 'Spline',
            'area-spline' => 'Area Spline',
            'bar' => 'Bar',
            'pie' => 'Pie'
        );
        return $this;
    }

    public function printChart() {
        $data_sets = func_get_args();
        $title = array_shift($data_sets);
        $data_values = "";
        foreach ($data_sets as $data_set) {
            $data_values .= $data_set->formatted_data['values'] . ", ";
            $names[] = $data_set->formatted_data['names'];
        }
        $names = $names[0];
        $x_label = ucwords(str_replace("_", " ", $data_sets[1]->group_by));
        $chart = "chart-".rand(100, 10000);

        $output = <<<MARKUP
        <h3>{$title}</h3>
        <div id="{$chart}"></div>
        <script type="text/javascript">
            var chart = c3.generate({
                bindto: '#{$chart}',
                data: {
                    columns: [
                        {$data_values}
                    ],
                    type: 'area-spline'
                },
                axis: {
                    x: {
                        type: 'category',
                        categories: {$names},
                        label: '{$x_label}',
                        tick: {
                            rotate: 75
                        },
                        height: 130
                    },
                    y: {
                        label: 'Jobs'
                    },
                },
                bar: {
                    width: {
                        ratio: 0.5 // this makes bar width 50% of length between ticks
                    }
                    // or
                    //width: 100 // this makes bar width 100px
                },
                transition: { duration: 2000 }
            });
        </script>
MARKUP;
        print $output;
    }

    protected function getReportTypes() {
        $report_types = array(
            "jobs_over_time",
            "jobs_per_crew",
            "jobs_in_area"
        );
        foreach ($report_types as $machine_name) {
            $this->report_types[$machine_name] = $this->makeFriendlyName($machine_name);
        }
        $this->report_type_select_html = $this->buildSelect($this->report_types, "Report Type");
        return $this;
    }

    protected function getCompareTypes() {
        $compare_types = array(
            "actual_job",
            "comeback"
        );
        foreach ($compare_types as $machine_name) {
            $this->compare_types[$machine_name] = $this->makeFriendlyName($machine_name);
        }
        $this->compare_types_select_html = $this->buildSelect($this->compare_types, "Compare");
        return $this;
    }


}

class jobs extends report {

    public $start_date;
    public $end_date;
    public $group_by;
    public $order_by;
    public $comeback = NULL; //All jobs.
    public $service = NULL; //All jobs.
    public $actual_job = NULL; //All jobs. TRUE = means it's the same as job card. FALSE = means the job was different.
    public $query;
    public $jobs = array(); //Array of jobGroup objects.
    public $formatted_data;
    public $sql = array();
    public $label = 'data';
    public $master_query;
    public $min_date;
    public $granularity;
    public $jobs_template;
    public $jobs_values;
    public $crew;
    public $client;
    public $area = NULL;

    public function __construct($label = NULL, $start_date = NULL, $end_date = NULL, $group_by = NULL, $order_by = NULL, $service = NULL, $comeback = NULL, $actual_job = NULL, $crew = NULL, $client = NULL, $area = NULL) {
        parent::__construct($start_date, $end_date);
        $this->start_date = $start_date;
        $this->end_date = $end_date;

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
         * Setting up filter for areas
         */
        if ($area != NULL && $this->area === NULL) {
            $this->area = $area;
        }
        if($this->area != "*" && $this->area !== NULL) {
            $area_object = new clients();
            $area_object->getClientsByArea($this->area['province'], "province");
            $ids = implode(",", $area_object->client_ids);
            $this->sql['province'] = "AND `client_name` != '' AND `client_id` IN ('{$ids}')";
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

        //$this->getJobs();

        //$this->formatData();

        return $this;
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
                  `client_name`
                FROM jobs
                WHERE 1";

        $this->master_query = "SELECT `date`, `crew_name`, `year`, `week_of_year`, `month`, `year_month`, `month_day`, `client_name`, COUNT(*) AS `count` FROM `jobs` WHERE 1 " . " " . $this->sql['date']. " " .$this->sql['group_by']. " " .$this->sql['order_by'];
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
            $stmt->bind_result($date, $crew_name, $year, $week_of_year, $month, $year_month, $month_day, $client_name, $count);

            while ($stmt->fetch()) {
                $r = new stdClass();
                $key_name = $this->group_by;
                $key = $$key_name;
                $r->$key_name = $key;
                $r->count = '0';
                $this->jobs_template[$key] = $r;
            }
            $stmt->close();
        }

        if ($stmt = $this->dbcon->prepare($this->query)) {
            $stmt->execute();
            $stmt->bind_result($date, $crew_name,  $count, $year, $week_of_year, $month, $year_month, $month_day, $client_name);
            while ($stmt->fetch()) {
                $key_name = $this->group_by;
                $key = $$key_name;
                $this->jobs_values[$key] = new jobGroup(array('date' => $date, 'crew_name' => $crew_name,  'count' => $count, 'year' => $year, 'week_of_year' => $week_of_year, 'month' => $month, 'year_month' => $year_month, 'month_day' => $month_day, 'client_name' => $client_name));
            }
            $stmt->close();
        }

        foreach($this->jobs_template as $template_key => $template_value) {
            if($this->jobs_values[$template_key]) {
                $this->jobs[$template_key] = $this->jobs_values[$template_key];
            } else {
                $this->jobs[$template_key] = $template_value;
            }
        }
        return $this;

    }

    public function formatData() {
        $this->formatted_data['names'] = array_keys($this->jobs);
        $this->formatted_data['values'][] = $this->label;
        foreach($this->jobs as $job_group) {
            $this->formatted_data['values'][] = $job_group->count;
        }
        return $this;
    }

}

class jobGroup extends report {
    public $date;
    public $crew_name;
    public $year;
    public $week_of_year;
    public $month_per_year;
    public $month;
    public $count;

    public function __construct($args=array()) {
        foreach ($args as $arg => $val) {
            $this->$arg = $val;
        }
        return $this;
    }
}

class clients extends report {
    public $clients;
    public $query;
    public $select_html;
    public $client_ids;

    public function __construct() {
        parent::__construct();
        $this->getClients();
        $this->buildSelect();
        return $this;
    }

    public function getClients () {
        $this->query = "SELECT DISTINCT(client_name) AS client_name FROM jobs WHERE 1 ORDER BY client_name ASC";

        if ($stmt = $this->dbcon->prepare($this->query)) {
            $stmt->execute();
            $stmt->bind_result($client_name);
            $this->clients['*'] = 'All';
            while ($stmt->fetch()) {
                $this->clients[] = $client_name;
            }
            $stmt->close();
            return $this;
        }
        return FALSE;
    }

    public function getClientsByArea($area, $area_type = "province") {
        if($area != "" && $this->province_id === NULL) {
            $this->province_id = $area;
        }
        $sql = "SELECT `client_id` FROM `areas` WHERE `{$area_type}_id` = '{$this->province_id}'";
        if ($stmt = $this->dbcon->prepare($sql)) {
            $stmt->execute();
            $stmt->bind_result($client_id);

            while ($stmt->fetch()) {
                $this->client_ids[] = $client_id;
            }
            $stmt->close();
            return $this;
        }
        return FALSE;
    }

    public function buildSelect() {
        return parent::buildSelect($this->clients, "Clients");
    }
}

class crews extends report {
    public $crews;
    public $query;

    public function __construct($start_date = NULL, $end_date = NULL, $client = NULL) {
        parent::__construct();
        return $this;
    }

    public function getCrews() {

        $this->query = "SELECT DISTINCT (crew_name) AS crew_name FROM jobs WHERE 1 ORDER BY crew_name ASC";

        if ($stmt = $this->dbcon->prepare($this->query)) {
            $stmt->execute();
            $stmt->bind_result($crew_name);
            $this->crews['*'] = 'All';
            while ($stmt->fetch()) {
                $this->crews[] = $crew_name;
            }
            $stmt->close();
            return $this;
        }
        return FALSE;
    }

    public function buildSelect() {
        return parent::buildSelect($this->crews, "Crews");
    }
}

class areas extends report {
    public $suburb_id;
    public $sub_region_id;
    public $region_id;
    public $province_id;
    public $suburbs;
    public $sub_regions;
    public $regions;
    public $provinces;
    public $area_types;
    public $area;
    public $area_type;

    function __construct() {
        parent::__construct();
        $this->area_types = array(
            'suburb' => 'suburbs',
            'sub_region' => 'sub_regions',
            'region' => 'regions',
            'province' => 'provinces'
        );
        return $this;
    }

    function getAreas($area_type) {
        $this->area_type = $area_type;
        if(in_array($this->area_type, $this->area_types)) {
            $area_type_column_name = array_search($this->area_type, $this->area_types);
            $sql = "SELECT GROUP_CONCAT(DISTINCT({$area_type_column_name}_id)) AS id, {$area_type_column_name} AS {$area_type_column_name} FROM areas WHERE {$area_type_column_name} != '' GROUP BY {$area_type_column_name}";
            if ($stmt = $this->dbcon->prepare($sql)) {
                $this->dbcon->use_result();
                $stmt->execute();
                $stmt->bind_result($id, $area_thing);
                $give['*'] = "All";
                while ($stmt->fetch()) {
                    $give[$id] = $area_thing;
                }
                $stmt->close();
                $t = $this->area_type;
                $this->$t = $give;
                return $this;
            }
        }
        return FALSE;
    }
}