<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class invs extends CI_Controller {


	public function index()
	{
		$this->load->model('invs_m');
		$data=$this->invs_m->data();
		$this->parser->parse('invs_v',$data);
		
	}
}
