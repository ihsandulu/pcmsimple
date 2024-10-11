<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class suratkeluar extends CI_Controller {


	public function index()
	{
		$this->load->model('suratkeluar_m');
		$data=$this->suratkeluar_m->data();
		$this->parser->parse('suratkeluar_v',$data);
		
	}
}
