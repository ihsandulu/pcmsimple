<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class bapprint extends CI_Controller {


	public function index()
	{	
		
		$iden=$this->db->get("identity");
		foreach($iden->result() as $identity){
			foreach($this->db->list_fields('identity') as $field){
				$data[$field]=$identity->$field;
			}
		}
		
		
		
		
		$in=$this->db
		->get("bap");
		//echo $this->db->last_query();
		foreach($in->result() as $gaji){
			foreach($this->db->list_fields('bap') as $field){
				 $data[$field]=$gaji->$field;	
			}	
		}
		$this->load->view('bapprint_v',$data);
		
	}
}
