<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class fop extends CI_Controller {


	public function index()
	{
		$this->load->model('fop_m');
		$data=$this->fop_m->data();
		$this->parser->parse('fop_v',$data);
		
	}
}
