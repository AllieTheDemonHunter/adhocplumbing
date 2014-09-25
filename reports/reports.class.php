<?php
/**
 * Created by PhpStorm.
 * User: allie
 * Date: 2014/09/22
 * Time: 7:53 PM
 */

class reports {
    public $dbcon;

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
        if(!$this->dbcon->thread_id) {
            $hostname = 'localhost';
            $username = 'root';
            $password = 'ekiswit';
            $database = 'adhoc_adhocpanmv_db2';

            $this->dbcon = new mysqli($hostname, $username, $password, $database);
        }

        $this->date_granularity_select_html = $this->buildSelect($this->getDateGranularity()->date_granularity, "Date Granularity");
        $this->chart_types_select_html = $this->buildSelect($this->getChartTypes()->chart_types, "Chart Types");
        $this->getReportTypes();
        $this->getCompareTypes();
        return $this;
    }

    public function __destruct() {
        //$this->dbcon->close();
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
        if ($result = $this->dbcon->query($sql)) {
            $this->min_date = $result->fetch_object()->min_date;
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
            "jobs_in_province",
            "jobs_in_region",
            "jobs_per_job_type"
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