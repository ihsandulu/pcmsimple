<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class parameter extends CI_Controller {


	public function index()
	{
		$this->tt = $this->load->database('tt', true);
		$this->load->model('parameter_m');
		$data=$this->parameter_m->data();
		$this->parser->parse('parameter_v', $data);
	}
}
