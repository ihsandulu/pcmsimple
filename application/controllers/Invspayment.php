<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class invspayment extends CI_Controller {


	public function index()
	{
		$this->load->model('invspayment_m');
		$data=$this->invspayment_m->data();
		$this->parser->parse('invspayment_v',$data);
		
	}
}
