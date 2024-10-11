<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class activity extends CI_Controller {


	public function index()
	{
		$this->tt = $this->load->database('tt', true);
		$this->load->model('activity_m');
		$data=$this->activity_m->data();
		$this->parser->parse('activity_v', $data);
	}
}
