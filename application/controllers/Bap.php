<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class bap extends CI_Controller {


	public function index()
	{
		$this->load->model('bap_m');
		$data=$this->bap_m->data();
		$this->parser->parse('bap_v',$data);
		
	}
}
