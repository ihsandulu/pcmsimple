<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class projectreport_print extends CI_Controller {


	public function index()
	{	
		
		
		$identit=$this->db
		->get("identity");
		foreach($identit->result() as $identity){
			foreach($this->db->list_fields('identity') as $field){
				$data[$field]=$identity->$field;
			}
		}
		
		
		$this->load->view('projectreport_print_v',$data);
		
	}
}
