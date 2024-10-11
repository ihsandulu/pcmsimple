<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class taskt extends CI_Controller {


	public function index()
	{
		$this->load->model('taskt_m');
		$data=$this->taskt_m->data();
		$this->parser->parse('taskt_v',$data);
		
	}
}
