<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class gaji_print extends CI_Controller {


	public function index()
	{	
		
		$iden=$this->db->get("identity");
		foreach($iden->result() as $identity){
			foreach($this->db->list_fields('identity') as $field){
				$data[$field]=$identity->$field;
			}
		}
		
		
		
		
		$in=$this->db
		->join("branch","branch.branch_id=gaji.branch_id","left")
		->join("user","user.user_id=gaji.user_id","left")
		->join("position","position.position_id=user.position_id","left")
		->where("gaji.gaji_no",$this->input->get("gaji_no"))
		->get("gaji");
		// echo $this->db->last_query();die;
		foreach($in->result() as $gaji){	
			foreach($this->db->list_fields('gaji') as $field){
				 $data[$field]=$gaji->$field;	
			}	
			foreach($this->db->list_fields('branch') as $field){
				 $data[$field]=$gaji->$field;	
			}	
			foreach($this->db->list_fields('user') as $field){
				 $data[$field]=$gaji->$field;	
			}	
			foreach($this->db->list_fields('position') as $field){
				 $data[$field]=$gaji->$field;	
			}	
		}
		$this->load->view('gaji_print_v',$data);
		
	}
}
