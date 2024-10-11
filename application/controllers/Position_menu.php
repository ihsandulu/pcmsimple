<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class position_menu extends CI_Controller {


	public function index()
	{
		$this->load->model('position_menu_m');
		$data=$this->position_menu_m->data();
		$this->parser->parse('position_menu_v',$data);
		
	}
}
