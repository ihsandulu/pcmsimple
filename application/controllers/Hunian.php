<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class hunian extends CI_Controller {


	public function index()
	{
		$this->load->model('hunian_m');
		$data=$this->hunian_m->data();
		$this->parser->parse('hunian_v',$data);
		
	}
}
