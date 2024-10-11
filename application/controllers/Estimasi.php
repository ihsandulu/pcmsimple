<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class estimasi extends CI_Controller {


	public function index()
	{
		$this->load->model('estimasi_m');
		$data=$this->estimasi_m->data();
		$this->parser->parse('estimasi_v',$data);
		
	}
}
