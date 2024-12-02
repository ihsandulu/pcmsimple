<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kota extends CI_Controller {


	public function index()
	{
		$this->load->model('kota_m');
		$data=$this->kota_m->data();
		$this->parser->parse('kota_v',$data);
		
	}
}
