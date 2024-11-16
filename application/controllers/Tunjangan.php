<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class tunjangan extends CI_Controller {


	public function index()
	{
		$this->load->model('tunjangan_m');
		$data=$this->tunjangan_m->data();
		$this->parser->parse('tunjangan_v',$data);
		
	}
}
