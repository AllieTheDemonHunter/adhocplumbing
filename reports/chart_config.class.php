<?php
/**
 * Created by PhpStorm.
 * User: allie
 * Date: 2014/09/23
 * Time: 2:15 PM
 */

class chart_config {
    public $actual_job;
    public $label;
    public $group_by;
    public $comeback;

    public function __construct($post) {
        if(is_array($post)) {
            foreach($post['args'] as $property => $value) {
                $this->$property = $value;
            }
            return $this;
        }
    }

    public function buildChart() {
        return new jobs($this->label, $this);
    }

    public function provideData() {
        return $this->buildChart();
    }

    public function all() {
        $this->label = "All";
        $this->actual_job = "*";
        $this->comeback = "*";
        return $this->buildChart();
    }

    public function actualJob($variant = FALSE) {
        $this->actual_job = $variant;
        switch ($this->actual_job) {
            case "same":
                $this->label = "Same";
                break;
            case "different":
                $this->label = "Different";
                break;
        }
        return $this->buildChart();
    }

    public function comeback($variant) {
        $this->comeback = $variant;
        switch ($variant) {
            case "good":
                $this->label = "Good Jobs";
                break;
            case "comeback":
                $this->label = "Comebacks";
                break;
        }
        return $this->buildChart();
    }

    /**
     * Must use all of the used/defined (above) filters.
     */
    public function getCrews() {
        $this->label = "crews"; //Not used but required.
        $this->group_by = "crew_name";
        return $this->provideData();
    }

    public function getClients() {
        $this->label = 'clients'; //Not used but required.
        $this->group_by = "client_name";
        return $this->provideData();
    }

    public function getProvinces() {
        $this->label = 'provinces'; //Not used but required.
        $this->group_by = "province";
        return $this->provideData();
    }

    public function getRegions() {
        $this->label = 'regions'; //Not used but required.
        $this->group_by = "region";
        return $this->provideData();
    }
} 