<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class po extends CI_Controller {


	public function index()
	{
		$this->load->model('po_m');
		$data=$this->po_m->data();
		$this->parser->parse('po_v',$data);
		
	}
}
