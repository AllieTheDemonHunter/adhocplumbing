<?php
/**
 * Created by PhpStorm.
 * User: allie
 * Date: 2014/09/22
 * Time: 7:51 PM
 */
class clients extends reports {
    public $clients;
    public $query;
    public $select_html;
    public $client_ids;

    public function __construct() {
        parent::__construct();
        return $this;
    }

    public function __destruct() {
        parent::__destruct();
    }

    public function getClients () {
        $this->query = "SELECT DISTINCT(client_name) AS client_name FROM job WHERE 1 ORDER BY client_name ASC";

        if ($result = $this->dbcon->query($this->query)) {
            $this->clients['*'] = 'All';
            while ($client_name = $result->fetch_object()) {
                $this->clients[] = $client_name->client_name;
            }
            $result->close();
            $this->dbcon->close();
            return $this;
        }
        return FALSE;
    }

    public function getClientsByArea($area, $area_type = "province") {
        if($area != "" && $this->province_id === NULL) {
            $this->province_id = $area;
        }
        $sql = "SELECT `client_id` AS `client_id` FROM `areas` WHERE `{$area_type}_id` = '{$this->province_id}'";
        if ($result = $this->dbcon->query($sql)) {
            while ($client_id = $result->fetch_object()) {
                $this->client_ids[] = $client_id->client_id;
            }
            $result->close();
            $this->dbcon->close();
            return $this;
        }
        return FALSE;
    }
}