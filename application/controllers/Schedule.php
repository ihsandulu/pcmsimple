<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class schedule extends CI_Controller {


	public function index()
	{
		$this->tt = $this->load->database('tt', true);
		$this->load->model('schedule_m');
		$data=$this->schedule_m->data();
		$this->parser->parse('schedule_v',$data);
		
	}
}
