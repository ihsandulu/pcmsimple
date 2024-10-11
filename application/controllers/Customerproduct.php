<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class customerproduct extends CI_Controller {


	public function index()
	{
		$this->load->model('customerproduct_m');
		$data=$this->customerproduct_m->data();
		$this->parser->parse('customerproduct_v',$data);
		
	}
}
