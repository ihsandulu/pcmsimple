<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class petty extends CI_Controller {


	public function index()
	{
		$this->load->model('petty_m');
		$data=$this->petty_m->data();
		$this->parser->parse('petty_v',$data);
		
	}
}
