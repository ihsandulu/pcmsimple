<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class projectproduct extends CI_Controller {


	public function index()
	{
		$this->load->model('projectproduct_m');
		$data=$this->projectproduct_m->data();
		$this->parser->parse('projectproduct_v',$data);
		
	}
}
