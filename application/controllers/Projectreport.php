<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class projectreport extends CI_Controller {


	public function index()
	{
		$this->load->model('projectreport_m');
		$data=$this->projectreport_m->data();
		$this->parser->parse('projectreport_v',$data);
		
	}
}
