<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class access extends CI_Controller {


	public function index()
	{
		$this->load->model('access_m');
		$data=$this->access_m->data();
		$this->parser->parse('access_v',$data);
		
	}
}
