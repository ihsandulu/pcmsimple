<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class type extends CI_Controller {


	public function index()
	{
		$this->tt = $this->load->database('tt', true);
		$this->load->model('type_m');
		$data=$this->type_m->data();
		$this->parser->parse('type_v', $data);
	}
}
