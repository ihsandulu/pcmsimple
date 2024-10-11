<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class invcost extends CI_Controller {


	public function index()
	{
		$this->load->model('invcost_m');
		$data=$this->invcost_m->data();
		$this->parser->parse('invcost_v',$data);
		
	}
}
