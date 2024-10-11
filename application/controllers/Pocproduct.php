<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pocproduct extends CI_Controller {


	public function index()
	{
		$this->load->model('pocproduct_m');
		$data=$this->pocproduct_m->data();
		$this->parser->parse('pocproduct_v',$data);
		
	}
}
