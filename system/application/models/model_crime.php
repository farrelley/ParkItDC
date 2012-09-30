<?php /**/ ?><?php
class Model_crime extends Model {

    function Model_crime() {
        parent::Model();
    }

	function getLatestCrime($limit = 7) {
		$sql = "SELECT ID, NAME, LOCATION, LATITUDE, LONGITUDE FROM Auto_Crime WHERE LOCATION <> '' ORDER BY DATE DESC  LIMIT 0,".$this->db->escape($limit);
		$query = $this->db->query($sql);
		return $query->result();
	}

	function getCrimeByCaseNumber($caseId) {
		$sql = "SELECT ac.ID, ac.NAME, ac.DATE, ac.LOCATION, ac.WARD, ac.SHIFT, ac.NARRATIVE, m.DESCRIPTION, ac.LATITUDE, ac.LONGITUDE FROM Auto_Crime ac lEFT JOIN Method m on ac.METHOD = m.METHOD WHERE ID = ".$this->db->escape($caseId);
		$query = $this->db->query($sql);
		return $query->result();
	}

	function getAllCrime($offset) {
		$sql = "SELECT ID, NAME, DATE, LOCATION, LATITUDE, LONGITUDE FROM Auto_Crime ORDER BY DATE ASC LIMIT ".$offset.",20";
		$query = $this->db->query($sql);
		return $query->result();
	}
}

?>