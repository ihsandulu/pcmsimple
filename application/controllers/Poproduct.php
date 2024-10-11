<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class poproduct extends CI_Controller {


	public function index()
	{
		$this->load->model('poproduct_m');
		$data=$this->poproduct_m->data();
		$this->parser->parse('poproduct_v',$data);
		
	}
}
