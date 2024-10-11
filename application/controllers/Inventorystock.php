<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class inventorystock extends CI_Controller {


	public function index()
	{
		$this->load->model('inventorystock_m');
		$data=$this->inventorystock_m->data();
		$this->parser->parse('inventorystock_v',$data);
		
	}
}
