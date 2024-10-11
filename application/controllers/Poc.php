<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class poc extends CI_Controller {


	public function index()
	{
		$this->load->model('poc_m');
		$data=$this->poc_m->data();
		$this->parser->parse('poc_v',$data);
		
	}
}
