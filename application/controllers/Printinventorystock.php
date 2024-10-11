<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class printinventorystock extends CI_Controller {


	public function index()
	{
		$this->load->model('printinventorystock_m');
		$data=$this->printinventorystock_m->data();
		$this->parser->parse('printinventorystock_v',$data);
		
	}
}
