<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class permintaan extends CI_Controller {


	public function index()
	{
		$this->load->model('permintaan_m');
		$data=$this->permintaan_m->data();
		$this->parser->parse('permintaan_v',$data);
		
	}
}
