<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class header extends CI_Controller {


	public function index()
	{
		$this->tt = $this->load->database('tt', true);
		$this->load->model('header_m');
		$data=$this->header_m->data();
		$this->parser->parse('header_v', $data);
	}
}
