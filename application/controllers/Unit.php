<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class unit extends CI_Controller {


	public function index()
	{
		$this->load->model('unit_m');
		$data=$this->unit_m->data();
		$this->parser->parse('unit_v',$data);
		
	}
}
