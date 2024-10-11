<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class subparameter extends CI_Controller {


	public function index()
	{
		$this->tt = $this->load->database('tt', true);
		$this->load->model('subparameter_m');
		$data=$this->subparameter_m->data();
		$this->parser->parse('subparameter_v', $data);
	}
}
