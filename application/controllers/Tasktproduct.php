<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class tasktproduct extends CI_Controller {


	public function index()
	{
		$this->load->model('tasktproduct_m');
		$data=$this->tasktproduct_m->data();
		$this->parser->parse('tasktproduct_v',$data);
		
	}
}
