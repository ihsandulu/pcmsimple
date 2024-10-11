<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class lappenjualan extends CI_Controller {


	public function index()
	{
		$this->load->model('lappenjualan_m');
		$data=$this->lappenjualan_m->data();
		$this->parser->parse('lappenjualan_v',$data);
		
	}
}
