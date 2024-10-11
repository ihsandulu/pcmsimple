<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class jualan extends CI_Controller {


	public function index()
	{
		$this->load->model('jualan_m');
		$data=$this->jualan_m->data();
		$this->parser->parse('jualan_v',$data);
		
	}
}
