<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class kecamatan extends CI_Controller {


	public function index()
	{
		$this->load->model('kecamatan_m');
		$data=$this->kecamatan_m->data();
		$this->parser->parse('kecamatan_v',$data);
		
	}
}
