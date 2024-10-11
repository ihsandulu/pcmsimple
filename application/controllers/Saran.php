<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class saran extends CI_Controller {


	public function index()
	{
		$this->load->model('saran_m');
		$data=$this->saran_m->data();
		$this->parser->parse('saran_v',$data);
		
	}
}
