<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class product extends CI_Controller {


	public function index()
	{
		$this->load->model('product_m');
		$data=$this->product_m->data();
		$this->parser->parse('product_v',$data);
		
	}
}
