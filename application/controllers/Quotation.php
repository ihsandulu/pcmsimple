<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class quotation extends CI_Controller {


	public function index()
	{
		$this->load->model('quotation_m');
		$data=$this->quotation_m->data();
		

		$this->parser->parse('quotation_v',$data);
		
	}
}
