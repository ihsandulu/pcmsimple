<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class invspaymentproduct extends CI_Controller {


	public function index()
	{
		$this->load->model('invspaymentproduct_m');
		$data=$this->invspaymentproduct_m->data();
		$this->parser->parse('invspaymentproduct_v',$data);
		
	}
}
