<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class sjkeluarproduct extends CI_Controller {


	public function index()
	{
		$this->load->model('sjkeluarproduct_m');
		$data=$this->sjkeluarproduct_m->data();
		$this->parser->parse('sjkeluarproduct_v',$data);
		
	}
}
