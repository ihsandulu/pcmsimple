<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class identity extends CI_Controller {


	public function index()
	{
		$this->load->model('identity_m');
		$data=$this->identity_m->data();
		$this->parser->parse('identity_v',$data);
		
	}
}
