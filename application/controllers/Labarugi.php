<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class labarugi extends CI_Controller {


	public function index()
	{
		$this->load->model('labarugi_m');
		$data=$this->labarugi_m->data();
		$this->parser->parse('labarugi_v',$data);
		
	}
}
