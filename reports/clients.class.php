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