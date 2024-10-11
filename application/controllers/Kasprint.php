<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kasprint extends CI_Controller {


	public function index()
	{
		$this->load->model('kasprint_m');
		$data=$this->kasprint_m->data();
		$this->parser->parse('kasprint_v',$data);
		
	}
}
