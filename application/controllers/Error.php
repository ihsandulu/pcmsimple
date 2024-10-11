<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class error extends CI_Controller {


	public function index()
	{
		
		$this->parser->parse('error_v');
		
	}
}
