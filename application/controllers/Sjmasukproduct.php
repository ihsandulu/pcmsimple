<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class sjmasukproduct extends CI_Controller {


	public function index()
	{
		$this->load->model('sjmasukproduct_m');
		$data=$this->sjmasukproduct_m->data();
		$this->parser->parse('sjmasukproduct_v',$data);
		
	}
}
