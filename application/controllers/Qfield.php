<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class qfield extends CI_Controller {


	public function index()
	{
		$this->load->model('qfield_m');
		$data=$this->qfield_m->data();
		$this->parser->parse('qfield_v',$data);
		
	}
}
