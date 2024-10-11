<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class task extends CI_Controller {


	public function index()
	{
		$this->load->model('task_m');
		$data=$this->task_m->data();
		$this->parser->parse('task_v',$data);
		
	}
}
