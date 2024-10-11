<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class vendorproduct extends CI_Controller {


	public function index()
	{
		$this->load->model('vendorproduct_m');
		$data=$this->vendorproduct_m->data();
		$this->parser->parse('vendorproduct_v',$data);
		
	}
}
