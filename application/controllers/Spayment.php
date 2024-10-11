<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class spayment extends CI_Controller {


	public function index()
	{
		$this->load->model('spayment_m');
		$data=$this->spayment_m->data();
		$this->parser->parse('spayment_v',$data);
		
	}
}
