<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class sumquotation extends CI_Controller {


	public function index()
	{
		$data["message"]="";
		$this->load->view('sumquotation_v',$data);
		
	}
}
