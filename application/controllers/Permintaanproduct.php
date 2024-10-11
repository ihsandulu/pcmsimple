<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class permintaanproduct extends CI_Controller {


	public function index()
	{
		$this->load->model('permintaanproduct_m');
		$data=$this->permintaanproduct_m->data();
		$this->parser->parse('permintaanproduct_v',$data);
		
	}
}
