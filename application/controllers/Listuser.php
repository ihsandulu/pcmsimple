<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class listuser extends CI_Controller {


	public function index()
	{
		$this->load->model('listuser_m');
		$data=$this->listuser_m->data();
		$this->parser->parse('listuser_v',$data);
		
	}
}
