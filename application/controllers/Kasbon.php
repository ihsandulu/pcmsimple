<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kasbon extends CI_Controller {


	public function index()
	{
		$this->load->model('kasbon_m');
		$data=$this->kasbon_m->data();
		$this->parser->parse('kasbon_v',$data);
		
	}
}
