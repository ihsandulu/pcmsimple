<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class tasktover extends CI_Controller {


	public function index()
	{
		$this->load->model('tasktover_m');
		$data=$this->tasktover_m->data();
		$this->load->view('tasktover_v',$data);
		
	}
}
