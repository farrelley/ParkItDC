<?php /**/ ?><?php

class Welcome extends Controller {

	function Welcome() {
		parent::Controller();
		$this->load->model('Model_crime');
		$this->load->model('Model_service');
	}
	
	function index() {
		$data['segment'] = "home";
		$data['AutoCrime'] = $this->Model_crime->getLatestCrime();
		$data['ComboSearches'] = $this->Model_tracker->getLatestComboSearches();
		$data['ServiceProblems'] = $this->Model_service->getLatestServiceProblems();
		$this->load->view('layout/header',$data);
		$this->load->view('layout/map');
		$this->load->view('welcome_message', $data);
		$this->load->view('layout/footer');
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */