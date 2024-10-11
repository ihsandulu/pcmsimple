<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class invpayment extends CI_Controller {


	public function index()
	{
		$this->load->model('invpayment_m');
		$data=$this->invpayment_m->data();
		$this->parser->parse('invpayment_v',$data);
		
	}
}
