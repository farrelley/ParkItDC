<?php /**/ ?><?php

class Contact extends Controller {

	function Contact() {
		parent::Controller();
	}
	
	function index() {		
		$data['segment'] = "contact";
		$data['title'] = "Contact";
		$data['pageDesc'] = '';
		
		$this->load->view('layout/header-nojs', $data);
		$this->load->view('layout/no-map', $data);
		$this->load->view('contact/contact', $data);
		$this->load->view('layout/footer');
	}
	
}