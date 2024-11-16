<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class bank extends CI_Controller {


	public function index()
	{
		$this->load->model('bank_m');
		$data=$this->bank_m->data();
		$this->parser->parse('bank_v',$data);
		
	}
}
