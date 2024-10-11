<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class site extends CI_Controller {


	public function index()
	{
		$this->tt = $this->load->database('tt', true);
		$this->load->model('site_m');
		$data=$this->site_m->data();
		$this->parser->parse('site_v', $data);
	}
}
