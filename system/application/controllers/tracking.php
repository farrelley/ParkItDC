<?php /**/ ?><?php

class Tracking extends Controller {

	function Tracking() {
		parent::Controller();
	}
	
	function index() {
		echo "index";
	}

	function address() {
		$address = $this->uri->segment(3);
		$lat = $this->uri->segment(4);
		$lng = $this->uri->segment(5);
		$this->Model_tracker->trackAddress($address, $lat, $lng);
	}
	
	function meter() {
		$meter = $this->uri->segment(3);
		$this->Model_tracker->trackMeter($meter);
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */