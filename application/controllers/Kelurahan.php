<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kelurahan extends CI_Controller {


	public function index()
	{
		$this->load->model('kelurahan_m');
		$data=$this->kelurahan_m->data();
		$this->parser->parse('kelurahan_v',$data);
		
	}
}
