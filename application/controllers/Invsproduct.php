<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class invsproduct extends CI_Controller {


	public function index()
	{
		$this->load->model('invsproduct_m');
		$data=$this->invsproduct_m->data();
		$this->parser->parse('invsproduct_v',$data);
		
	}
}
