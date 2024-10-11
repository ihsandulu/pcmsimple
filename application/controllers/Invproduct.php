<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class invproduct extends CI_Controller {


	public function index()
	{
		$this->load->model('invproduct_m');
		$data=$this->invproduct_m->data();
		$this->parser->parse('invproduct_v',$data);
		
	}
}
