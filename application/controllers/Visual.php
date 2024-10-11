<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class visual extends CI_Controller {


	public function index()
	{
		$this->tt = $this->load->database('tt', true);
		$this->load->model('visual_m');
		$data=$this->visual_m->data();
		$this->parser->parse('visual_v', $data);
	}
}
