<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class inventorylog extends CI_Controller {


	public function index()
	{
		$this->load->model('inventorylog_m');
		$data=$this->inventorylog_m->data();
		$this->parser->parse('inventorylog_v',$data);
		
	}
}
