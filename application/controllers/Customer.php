<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class customer extends CI_Controller {


	public function index()
	{
		$this->load->model('customer_m');
		$data=$this->customer_m->data();
		$this->parser->parse('customer_v',$data);
		
	}
}
