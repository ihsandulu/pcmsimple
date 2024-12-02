<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class provinsi extends CI_Controller {


	public function index()
	{
		$this->load->model('provinsi_m');
		$data=$this->provinsi_m->data();
		$this->parser->parse('provinsi_v',$data);
		
	}
}
