<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class followup extends CI_Controller {


	public function index()
	{
		$this->load->model('followup_m');
		$data=$this->followup_m->data();
		$this->parser->parse('followup_v',$data);
		
	}
}
