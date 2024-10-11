<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class warehouse extends CI_Controller {


	public function index()
	{
		$this->load->model('warehouse_m');
		$data=$this->warehouse_m->data();
		$this->parser->parse('warehouse_v',$data);
		
	}
}
