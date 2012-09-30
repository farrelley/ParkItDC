<?php /**/ ?><?php

class Meter extends Controller {

	function Meter() {
		parent::Controller();
		$this->load->model('Model_service');
		$this->load->library('pagination');
	}
	
	function index() {
		$data['segment'] = "";
		$data['meterNumber'] = $this->uri->segment(2);
		$data['RecentSearch'] = $this->Model_tracker->getLatestMeterSearches();
		
		$this->load->view('layout/header', $data);
		$this->load->view('meter/map', $data);
		$this->load->view('meter/main', $data);
		$this->load->view('layout/footer');
	}
	
	function issues() {
				$data['segment'] = "";
		$meter = $this->uri->segment(3);
		if($meter == "") {
			redirect('/meter', 'location');
		} else {
			$data['IssueData'] = $this->Model_service->getProblemsByMeterNumber($meter);
			$data['ServiceProblems'] = $this->Model_service->getLatestServiceProblems(15);
			$data['MeterNumber'] = $meter;
			$data['title'] = "Parking Meter Issues &amp; Problems";
			$data['pageDesc'] = "<p>Below is a list of recent issues on particular parking meters throughout the district.  To view the location of the meter on the map just click on the 
			parking meter number or click on the address to see other location specific parking data.  You can also view a history of all parking meter issues &amp; problems ".anchor('meter/view','here')."</p>";
		}
		$this->load->view('layout/header', $data);
		$this->load->view('layout/no-map', $data);
		$this->load->view('meter/issues', $data);
		$this->load->view('layout/footer');
	}

	function view() {
				$data['segment'] = "";
		if($this->uri->segment(4) == "") 
			$x = 0;
		else
			$x = $this->uri->segment(4);

		$data['IssueData'] = $this->Model_service->getAllIssues($x);

		$config['base_url'] = site_url().'/meter/view/page/';
		$config['total_rows'] = $this->db->count_all('Hanson');
		$config['per_page'] = '20';
		$config['uri_segment'] = 4;
		$config['num_links'] = 5;
		$this->pagination->initialize($config);

		$data['links'] = $this->pagination->create_links();

		$data['title'] = "Parking Meter Issues &amp; Problems";
		$data['pageDesc'] = 'Below is a full history of issues and problems that have been reported by residents. They are listed in order by most recent open issues. If you would like to see more information about a particular parking meter just click on the meter number. From the more information page you will be able to map the meter to see its location.';
		
		
		$this->load->view('layout/header-nojs', $data);
		$this->load->view('layout/no-map', $data);
		$this->load->view('meter/allMeters', $data);
		$this->load->view('layout/footer');
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */