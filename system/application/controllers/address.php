<?php /**/ ?><?php

class Address extends Controller {

	function Address() {
		parent::Controller();	
	}
	
	function index() {
		$data['segment'] = "";
		$data['lat'] = $this->uri->segment(2);
		$data['lng'] = $this->uri->segment(3);
	
		//echo $data['latlng'];
		$data['RecentSearch'] = $this->Model_tracker->getLatestAddressSearches();
		$this->load->view('layout/header', $data);
		$this->load->view('address/map');
		$this->load->view('address/main', $data);
		$this->load->view('layout/footer');
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */