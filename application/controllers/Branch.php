<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class branch extends CI_Controller {


	public function index()
	{
		$this->load->model('branch_m');
		$data=$this->branch_m->data();
		$this->parser->parse('branch_v',$data);
		
	}
}
