<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class faq extends CI_Controller {


	public function index()
	{
		$this->load->model('faq_m');
		$data=$this->faq_m->data();
		$this->parser->parse('faq_v',$data);
		
	}
}
