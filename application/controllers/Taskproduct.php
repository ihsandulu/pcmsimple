<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class taskproduct extends CI_Controller {


	public function index()
	{
		$this->load->model('taskproduct_m');
		$data=$this->taskproduct_m->data();
		$this->parser->parse('taskproduct_v',$data);
		
	}
}
