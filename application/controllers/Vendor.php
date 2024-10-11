<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class vendor extends CI_Controller {


	public function index()
	{
		$this->load->model('vendor_m');
		$data=$this->vendor_m->data();
		$this->parser->parse('vendor_v',$data);
		
	}
}
