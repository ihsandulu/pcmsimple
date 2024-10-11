<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class suratkeluar_list_print extends CI_Controller {


	public function index()
	{	
		
		$iden=$this->db->get("identity");
		foreach($iden->result() as $identity){
			foreach($this->db->list_fields('identity') as $field){
				$data[$field]=$identity->$field;
			}
		}
	
		$this->load->view('suratkeluar_list_print_v',$data);
		
	}
}
