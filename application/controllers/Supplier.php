<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class supplier extends CI_Controller {


	public function index()
	{
		$this->load->model('supplier_m');
		$data=$this->supplier_m->data();
		$this->parser->parse('supplier_v',$data);
		
	}
}
