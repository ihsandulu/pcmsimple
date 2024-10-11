<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pettyprint extends CI_Controller {


	public function index()
	{
		$this->load->model('pettyprint_m');
		$data=$this->pettyprint_m->data();
		$this->parser->parse('pettyprint_v',$data);
		
	}
}
