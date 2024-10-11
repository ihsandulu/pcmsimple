<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class wo extends CI_Controller {


	public function index()
	{
		$this->load->model('wo_m');
		$data=$this->wo_m->data();
		$this->parser->parse('wo_v',$data);
		
	}
}
