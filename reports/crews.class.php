<?php
/**
 * Created by PhpStorm.
 * User: allie
 * Date: 2014/09/22
 * Time: 7:53 PM
 */
class crews extends reports {
    public $crews;
    public $query;

    public function __construct($start_date = NULL, $end_date = NULL, $client = NULL) {
        parent::__construct();
        return $this;
    }

    public function __destruct() {
        parent::__destruct();
    }

    public function getCrews() {

        $this->query = "SELECT DISTINCT (crew_name) AS crew_name FROM job WHERE 1 ORDER BY crew_name ASC";

        if ($result = $this->dbcon->query($this->query)) {
            $this->crews['*'] = 'All';
            while ($crew = $result->fetch_object()) {
                $this->crews[] = $crew->crew_name;
            }
            $result->close();
            $this->dbcon->close();
            return $this;
        }
        return FALSE;
    }

    public function buildSelect() {
        return parent::buildSelect($this->crews, "Crews");
    }
}