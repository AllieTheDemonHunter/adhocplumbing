<?php
/**
 * Created by PhpStorm.
 * User: allie
 * Date: 2014/09/22
 * Time: 7:51 PM
 */

class areas extends reports {
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

    public function __destruct() {
        parent::__destruct();
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