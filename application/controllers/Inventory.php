<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class inventory extends CI_Controller {


	public function index()
	{
		$this->load->model('inventory_m');
		$data=$this->inventory_m->data();
		$this->parser->parse('inventory_v',$data);
		
	}
}
