<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class gajitype extends CI_Controller {


	public function index()
	{
		$this->load->model('gajitype_m');
		$data=$this->gajitype_m->data();
		$this->parser->parse('gajitype_v',$data);
		
	}
}
