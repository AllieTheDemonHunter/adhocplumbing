<?php
/**
 * Created by PhpStorm.
 * User: allie
 * Date: 2014/09/25
 * Time: 8:37 AM
 */

class provinces extends areas {
    public $query;
    function __construct() {
        parent::__construct();
        return $this;
    }

    public function getProvinces() {
        return $this->getAreas("province");
    }
}