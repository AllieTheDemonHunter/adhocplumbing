<?php
/**
 * Created by PhpStorm.
 * User: allie
 * Date: 2014/09/22
 * Time: 7:52 PM
 */
class jobs extends reports {
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

    public function __destruct() {
        parent::__destruct();
    }
}