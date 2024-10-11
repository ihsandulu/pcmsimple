<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class grouping extends CI_Controller {


	public function index()
	{
		$this->tt = $this->load->database('tt', true);
		
		$this->load->model('equipment_m');
		$data=$this->equipment_m->data();
		$this->parser->parse('equipment_v',$data);
		
	}
}
