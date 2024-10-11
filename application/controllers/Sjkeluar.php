<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class sjkeluar extends CI_Controller {


	public function index()
	{
		$this->load->model('sjkeluar_m');
		$data=$this->sjkeluar_m->data();
		$this->parser->parse('sjkeluar_v',$data);
		
	}
}
