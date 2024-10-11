<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class inv extends CI_Controller {


	public function index()
	{
		$this->load->model('inv_m');
		$data=$this->inv_m->data();
		$this->parser->parse('inv_v',$data);
		
	}
}
