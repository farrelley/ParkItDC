<?php /**/ ?><?php
class Model_tracker extends Model {

    function Model_tracker() {
        parent::Model();
    }

	function trackAddress($address, $lat, $lng) {
		$sql = "INSERT INTO Recent_Searches (TYPE, VALUE, LATITUDE, LONGITUDE) VALUES ('Address', ".$this->db->escape($address).", ".$this->db->escape($lat).", ".$this->db->escape($lng).")";
		$this->db->query($sql);
	}
	
	function trackMeter($meterNum) {
		$sql = "INSERT INTO Recent_Searches (TYPE, VALUE) VALUES ('Meter', ".$this->db->escape($meterNum).")";
		$this->db->query($sql);
	}

	function getLatestAddressSearches() {
		$sql = "SELECT distinct(Value), LATITUDE, LONGITUDE From Recent_Searches WHERE Type = 'Address' ORDER BY ID DESC LIMIT 0,8";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function getLatestMeterSearches() {
		$sql = "SELECT distinct(Value) From Recent_Searches WHERE Type = 'Meter' ORDER BY ID DESC LIMIT 0,8";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function getLatestComboSearches() {
		$sql = "SELECT distinct(Value),Type, LATITUDE, LONGITUDE From Recent_Searches ORDER BY ID DESC LIMIT 0,9";
		$query = $this->db->query($sql);
		return $query->result();
	}
}

?>