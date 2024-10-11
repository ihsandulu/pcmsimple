<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cpayment extends CI_Controller {


	public function index()
	{
		$this->load->model('cpayment_m');
		$data=$this->cpayment_m->data();
		$this->parser->parse('cpayment_v',$data);
		
	}
}
