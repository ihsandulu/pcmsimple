<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class gajid extends CI_Controller {


	public function index()
	{
		$this->load->model('gajid_m');
		$data=$this->gajid_m->data();
		$this->parser->parse('gajid_v',$data);
		
	}
}
