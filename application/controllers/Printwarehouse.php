<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class printwarehouse extends CI_Controller {


	public function index()
	{
		$this->load->model('printwarehouse_m');
		$data=$this->printwarehouse_m->data();
		$this->parser->parse('printwarehouse_v',$data);
		
	}
}
