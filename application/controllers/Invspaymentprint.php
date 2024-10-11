<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class invspaymentprint extends CI_Controller {


	public function index()
	{	
		
		$iden=$this->db->get("identity");
		foreach($iden->result() as $identity){
			foreach($this->db->list_fields('identity') as $field){
				$data[$field]=$identity->$field;
			}
		}
		
		
		
		
		$in=$this->db
		->select("*,invspayment.invspayment_no As ino")
		->join("invspaymentproduct","invspaymentproduct.invspayment_no=invspayment.invspayment_no","left")
		->join("methodpayment","methodpayment.methodpayment_id=invspayment.methodpayment_id","left")
		->where("invspayment.invspayment_no",$this->input->get("invspayment_no"))
		->get("invspayment");
		//echo $this->db->last_query();die;
		foreach($in->result() as $invs){	
			foreach($this->db->list_fields('invspaymentproduct') as $field){
				$data[$field]=$invs->$field;			
			}
			foreach($this->db->list_fields('methodpayment') as $field){
				$data[$field]=$invs->$field;			
			}			
			foreach($this->db->list_fields('invspayment') as $field){
				 $data[$field]=$invs->$field;	
			}	
			$data["invspayment_no"]=$invs->ino;
		}
		$this->load->view('invspaymentprint_v',$data);
		
	}
}
