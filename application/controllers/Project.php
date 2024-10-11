<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class project extends CI_Controller {


	public function index()
	{
		$this->load->model('project_m');
		$data=$this->project_m->data();
		$this->parser->parse('project_v',$data);
		
	}
}
