<?php /**/ ?><?php

class Crime extends Controller {

	function Crime() {
		parent::Controller();
		$this->load->model('Model_crime');
		$this->load->library('pagination');
	}
	
	function index() {
		redirect('', 'location');
	}

	function casenumber() {
		$data['segment'] = "";
		$crimeid = $this->uri->segment(3);
		if($crimeid == "") {
			redirect('', 'location');
		} else {
			$data['CrimeData'] = $this->Model_crime->getCrimeByCaseNumber($crimeid);
			$data['AutoCrime'] = $this->Model_crime->getLatestCrime(15);
			$data['MeterNumber'] = 'Auto Crime: ';
			$data['title'] = "Auto Crime";
			$data['pageDesc'] = "<p>Below are details about a particular crime against an automobile. To see more auto related crimes in the are just click on the address below.
			You can also view a history of all auto crimes ".anchor('crime/view','here').".</p>";
		}
		$this->load->view('layout/header',$data);
		$this->load->view('layout/no-map', $data);
		$this->load->view('crime/main', $data);
		$this->load->view('layout/footer');
	}

	function view() {
		$data['segment'] = "";
		if($this->uri->segment(4) == "") 
			$x = 0;
		else
			$x = $this->uri->segment(4);

		$data['CrimeData'] = $this->Model_crime->getAllCrime($x);

		$config['base_url'] = site_url().'/crime/view/page/';
		$config['total_rows'] = $this->db->count_all('Auto_Crime');
		$config['per_page'] = '20';
		$config['uri_segment'] = 4;
		$config['num_links'] = 5;
		$this->pagination->initialize($config);

		$data['links'] = $this->pagination->create_links();

		$data['pageDesc'] = 'Below is a list of crimes that were committed involving automobiles. They are listed in order by most recent.  If you would like too see more information about a particular crime just click on the case number. Otherwise you can click on the address to see other auto crimes in the same area.';
		$data['title'] = "Crime Involving Auto's";
		
		$this->load->view('layout/header-nojs',$data);
		$this->load->view('layout/no-map', $data);
		$this->load->view('crime/allCrime', $data);
		$this->load->view('layout/footer');
	}
}