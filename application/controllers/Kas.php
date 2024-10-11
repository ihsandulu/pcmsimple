<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kas extends CI_Controller {


	public function index()
	{
		$this->load->model('kas_m');
		$data=$this->kas_m->data();
		$this->parser->parse('kas_v',$data);
		
	}
}
