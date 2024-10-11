<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class sjmasuk extends CI_Controller {


	public function index()
	{
		$this->load->model('sjmasuk_m');
		$data=$this->sjmasuk_m->data();
		$this->parser->parse('sjmasuk_v',$data);
		
	}
}
