<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class register extends CI_Controller {


	public function index()
	{
		$this->load->model('register_m');
		$data=$this->register_m->data();
		$this->parser->parse('register_v',$data);
		
	}
}
