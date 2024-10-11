<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class resetpassword extends CI_Controller {


	public function index()
	{
		$this->load->model('resetpassword_m');
		$data=$this->resetpassword_m->data();
		$this->parser->parse('resetpassword_v',$data);
		
	}
}
