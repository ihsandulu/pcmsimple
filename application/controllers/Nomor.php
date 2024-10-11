<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class nomor extends CI_Controller {


	public function index()
	{
		$this->load->model('nomor_m');
		$data=$this->nomor_m->data();
		$this->parser->parse('nomor_v',$data);
		
	}
}
