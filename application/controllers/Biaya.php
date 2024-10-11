<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class biaya extends CI_Controller {


	public function index()
	{
		$this->load->model('biaya_m');
		$data=$this->biaya_m->data();
		$this->parser->parse('biaya_v',$data);
		
	}
}
