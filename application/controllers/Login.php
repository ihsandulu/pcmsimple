<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {


	public function index()
	{
		//ada
		$this->load->model('login_m');
		$data=$this->login_m->data();	
		$this->parser->parse('login_v',$data);
		
	}
}
