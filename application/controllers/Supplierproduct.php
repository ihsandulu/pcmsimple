<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class supplierproduct extends CI_Controller {


	public function index()
	{
		$this->load->model('supplierproduct_m');
		$data=$this->supplierproduct_m->data();
		$this->parser->parse('supplierproduct_v',$data);
		
	}
}
