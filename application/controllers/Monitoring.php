<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class monitoring extends CI_Controller {


	public function index()
	{
		$this->tt = $this->load->database('tt', true);
		$this->load->model('monitoring_m');
		$data=$this->monitoring_m->data();
		$this->parser->parse('monitoring_v', $data);
	}
}
