<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class cekuser extends CI_Controller {


	public function index()
	{
		$useremail=$this->db
		->get_where("user",array("user_email"=>$this->input->get("id")));
		echo $useremail->num_rows();
		
	}
}
