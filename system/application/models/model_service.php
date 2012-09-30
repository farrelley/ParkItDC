<?php /**/ ?><?php
class Model_service extends Model {

    function Model_service() {
        parent::Model();
    }

	function getLatestServiceProblems($limit = 9) {
		$sql = "SELECT METERNUM, SERVICE_CODE_DESC FROM Hanson WHERE METERNUM <> 'N/A' ORDER BY SERVICE_ORDER_DATE DESC LIMIT 0,".$this->db->escape($limit);
		$query = $this->db->query($sql);
		return $query->result();
	}

	
	function getProblemsByMeterNumber($MeterNumber) {
		$sql = "SELECT * FROM Hanson WHERE METERNUM = ".$this->db->escape($MeterNumber)." ORDER BY SERVICE_ORDER_STATUS DESC, SERVICE_ORDER_DATE";
		$query = $this->db->query($sql);
		return $query->result();
	} 

	function getAllIssues($offset) {
		$sql = "SELECT * FROM Hanson ORDER BY SERVICE_ORDER_STATUS DESC, SERVICE_ORDER_DATE DESC LIMIT ".$offset.", 20";
		$query = $this->db->query($sql);
		return $query->result();
	} 
	
}
?>