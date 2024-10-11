<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user extends CI_Controller {


	public function index()
	{
		$this->load->model('user_m');
		$data=$this->user_m->data();
		$this->parser->parse('user_v',$data);
		
	}
}
