<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class suratkeluar_print extends CI_Controller {


	public function index()
	{	
		
		$iden=$this->db->get("identity");
		foreach($iden->result() as $identity){
			foreach($this->db->list_fields('identity') as $field){
				$data[$field]=$identity->$field;
			}
		}
		
		
		
		
		$in=$this->db
		->join("branch","branch.branch_id=suratkeluar.branch_id","left")
		->where("suratkeluar.suratkeluar_no",$this->input->get("suratkeluar_no"))
		->get("suratkeluar");
		//echo $this->db->last_query();
		foreach($in->result() as $suratkeluar){	
			foreach($this->db->list_fields('suratkeluar') as $field){
				 $data[$field]=$suratkeluar->$field;	
			}	
			foreach($this->db->list_fields('branch') as $field){
				 $data[$field]=$suratkeluar->$field;	
			}	
		}
		$this->load->view('suratkeluar_print_v',$data);
		
	}
}
