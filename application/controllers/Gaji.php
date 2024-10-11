<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class gaji extends CI_Controller {


	public function index()
	{
		$this->load->model('gaji_m');
		$data=$this->gaji_m->data();
		$this->parser->parse('gaji_v',$data);
		
	}
}
