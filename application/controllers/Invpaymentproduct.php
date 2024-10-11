<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class invpaymentproduct extends CI_Controller {


	public function index()
	{
		$this->load->model('invpaymentproduct_m');
		$data=$this->invpaymentproduct_m->data();
		$this->parser->parse('invpaymentproduct_v',$data);
		
	}
}
