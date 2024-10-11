<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class quotationproduct extends CI_Controller {


	public function index()
	{
		$this->load->model('quotationproduct_m');
		$data=$this->quotationproduct_m->data();
		$this->parser->parse('quotationproduct_v',$data);
		
	}
}
