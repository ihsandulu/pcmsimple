<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class gudang extends CI_Controller {


	public function index()
	{
		$this->load->model('gudang_m');
		$data=$this->gudang_m->data();
		$this->parser->parse('gudang_v',$data);
		
	}
}
