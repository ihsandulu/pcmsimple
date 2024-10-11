<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class permintaanprint extends CI_Controller {


	public function index()
	{	
					
		$identit=$this->db
		->get("identity");
		foreach($identit->result() as $identity){
			foreach($this->db->list_fields('identity') as $field){
				$data[$field]=$identity->$field;
			}
		}
		$permintaan=$this->db
		->where("permintaan_no",$this->input->get("permintaan_no"))
		->get("permintaan");
		foreach($permintaan->result() as $permintaan){
			foreach($this->db->list_fields('permintaan') as $field){
				$data[$field]=$permintaan->$field;
			}
		}
		
		
		$this->load->view('permintaanprint_v',$data);
		
	}
}
