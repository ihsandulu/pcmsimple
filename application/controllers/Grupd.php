<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class grupd extends CI_Controller {


	public function index()
	{
		$this->load->model('grupd_m');
		$data=$this->grupd_m->data();
		$this->parser->parse('grupd_v',$data);
		
	}
}
