<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class siaran extends CI_Controller {


	public function index()
	{
		$this->tt = $this->load->database('tt', true);
		$this->load->model('siaran_m');
		$data=$this->siaran_m->data();
		$this->parser->parse('siaran_v', $data);
	}
}
