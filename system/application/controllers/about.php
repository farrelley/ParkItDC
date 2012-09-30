<?php /**/ ?><?php

class About extends Controller {

	function About() {
		parent::Controller();
	}
	
	function index() {		
		$data['segment'] = "about";
		$data['title'] = "About";
		$data['pageDesc'] = '';
		
		$this->load->view('layout/header-nojs', $data);
		$this->load->view('layout/no-map', $data);
		$this->load->view('about/about', $data);
		$this->load->view('layout/footer');
	}
	
}