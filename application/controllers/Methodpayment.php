<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class methodpayment extends CI_Controller {


	public function index()
	{
		$this->load->model('methodpayment_m');
		$data=$this->methodpayment_m->data();
		$this->parser->parse('methodpayment_v',$data);
		
	}
}
